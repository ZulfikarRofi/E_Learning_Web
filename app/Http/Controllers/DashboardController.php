<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Bot;
use App\Models\Groups;
use App\Models\ListChat;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\Option;
use App\Models\Options;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

// require_once 'vendor/autoload.php'; // Include Sastrawi autoload.php or adjust the path
use Sastrawi\Stemmer\StemmerFactory;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        $idUser = auth()->user()->guru_id;
        $dataMapel = DB::table('kelas')->selectRaw('mapel.id as id, nama_mapel, nama_kelas,mapel_id, hari_pelajaran, jam_pelajaran')
            ->join('mapel',  'kelas.id', '=', 'mapel.kelas_id')
            ->rightJoin('guru', 'mapel.guru_id', '=', 'guru.id')
            ->where('guru_id', $idUser)
            ->get();
        $userdata = DB::table('guru')->where('id', $idUser)->first();

        //recently activities
        $activities = new Collection();

        $today = Carbon::now();
        $yesterday = Carbon::now()->subDay(1);

        $thisYear = Carbon::now()->format('Y');
        $nextYear = Carbon::now()->addYear(1)->format('Y');
        $thisDay = $today->format('Y-m-d');
        // dd($thisYear, $nextYear);

        $kuis = DB::table('kuis')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->whereBetween('kuis.created_at', [$yesterday, $today])
            ->get();

        $modul = DB::table('modul')
            ->join('mapel', 'modul.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->whereBetween('modul.created_at', [$yesterday, $today])
            ->get();

        $task = DB::table('task')
            ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->whereBetween('task.created_at', [$yesterday, $today])
            ->get();

        foreach ($kuis as $b) {
            if ($activities->where('name', $b->nama_kuis)->count() === 0) {
                $activities->push([
                    'name' => $b->nama_kuis,
                    'category' => 'Kuis',
                    'tanggal_regis' => $b->created_at,
                    'status' => 'Dipublikasikan',
                ]);
            }
        }

        foreach ($task as $b) {
            if ($activities->where('name', $b->nama_tugas)->count() === 0) {
                $activities->push([
                    'name' => $b->nama_tugas,
                    'category' => 'Tugas',
                    'tanggal_regis' => $b->created_at,
                    'status' => 'Dipublikasikan',
                ]);
            }
        }

        foreach ($modul as $b) {
            if ($activities->where('name', $b->nama_modul)->count() === 0) {
                $activities->push([
                    'name' => $b->nama_modul,
                    'category' => 'Materi',
                    'tanggal_regis' => $b->created_at,
                    'status' => 'Dipublikasikan',
                ]);
            }
        }

        View::share('activities', $activities);

        // dd($activities);
        return view('pages.dashboard', compact('dataMapel', 'userdata'));
    }

    public function botRingkas(Request $request)
    {
        $file_contents = File::get(database_path('factories/datamaster.json'));
        $dataRingkasan = new Collection();
        $tokening = new Collection();
        $resultToken = new Collection();
        $data = json_decode($file_contents, true);
        if ($data && isset($data['Datamaster'])) {
            $sentences  = $data['Datamaster'];
            foreach ($sentences as $s) {
                $dataRingkasan->push([
                    'data' => $s
                ]);
                $words = explode(' ', $s);
                $tokening->push([
                    'words' => $words
                ]);
            }
            foreach ($tokening as $token) {
                if (isset($token['words']) && is_array($token['words'])) {
                    foreach ($token['words'] as $word) {
                        $resultToken->push([
                            'data' => $word
                        ]);
                    }
                }
            }
        } else {
            echo 'Error data';
        }

        // dd($tokening ,$resultToken);

        return view('pages.botringkas', compact('dataRingkasan', 'tokening', 'resultToken'));
    }

    public function chatbotDashboard()
    {

        $data = DB::table('mapel')->selectRaw('mapel.id as idMapel, kelas.id as idKelas, nama_mapel, nama_kelas')->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')->orderBy('nama_kelas')->get();


        $dataBot = new Collection();
        $bot = Bot::all();
        if (empty($bot)) {
            //
        } else {
            $allBot = DB::table('bot')
                ->selectRaw('bot.id as idBot, mapel.id as idMapel, kelas.id as idKelas, nama_kelas, nama_bot, nama_mapel, bot.updated_at as updated_at, bot.created_at as created_at')
                ->join('mapel', 'bot.mapel_id', '=', 'mapel.id')
                ->join('kelas', 'bot.kelas_id', '=', 'kelas.id')
                ->get();
        }

        if ($allBot) {
            foreach ($allBot as $ab) {
                $lastUpdate = Carbon::parse($ab->updated_at);
                $newUpdate = Carbon::now()->diff($lastUpdate)->days;
                $dataBot->push([
                    'bot_id' => $ab->idbot,
                    'kelas_id' => $ab->idkelas,
                    'nama_bot' => $ab->nama_bot,
                    'total_data' => 0,
                    'last_update' => $newUpdate,
                ]);
            }
        }

        // dd($ab);
        return view('pages.chatbot', compact('data', 'dataBot'));
    }

    public function createBot(Request $request)
    {
        $request->validate([
            'nama_bot' => 'required',
            'id_kelasMapel' => 'required',
        ]);

        $newBot = new Bot();
        $newBot->nama_bot = $request->nama_bot;
        $newBot->kelas_id = $request->id_kelasMapel[4];
        $newBot->mapel_id = $request->id_kelasMapel[1];
        $idBot = DB::table('bot')->orderByDesc('id')->pluck('id')->first();
        $codeKelas = str_pad($newBot->kelas_id + 1, 3, '0', STR_PAD_LEFT);
        $codeMapel = str_pad($newBot->mapel_id + 1, 3, '0', STR_PAD_LEFT);
        $newBot->bot_number = 'Bot-' . $idBot . $codeKelas . '-' . $codeMapel;
        $newBot->save();

        // dd($newBot);

        return redirect('/chatbot')->with('success', 'Bot Baru Berhasil Ditambahkan');
    }

    public function createListChatbot(Request $request)
    {
        $request->validate([
            'bot_id' => 'required',
            'kelas_id' => 'required',
        ]);

        $idSiswa = new Collection();
        $dataSiswa = DB::table("siswa")
            ->selectRaw("id, name")
            ->where('kelas_id', $request->kelas_id)
            ->get();

        // dd($dataSiswa, $request->kelas_id, $request->bot_id);
        // foreach($dataSiswa as $ds){
        //     $idSiswa->push([
        //         'id' => $ds->id,
        //         'name' => $ds->name,
        //     ]);
        // }

        foreach ($dataSiswa as $dS) {
            $ListChat = new ListChat();
            $ListChat->bot_id = $request->bot_id;
            $ListChat->siswa_id = $dS->id;
            $ListChat->save();
            // dd($ListChat);
        }

        // dd($idSiswa);
        // echo $idSiswa;
        return redirect()->back()->with('success', '');
    }

    public function detailChatbot($id)
    {

        $dataBot = DB::table('bot')
            ->join('kelas', 'bot.kelas_id', '=', 'kelas.id')
            ->join('mapel', 'bot.mapel_id', '=', 'mapel.id')
            ->where('bot.id', $id)
            ->first();

        $listSiswa = DB::table('list_chat')
            ->join('siswa', 'list_chat.siswa_id', '=', 'siswa.id')
            ->join('bot', 'list_chat.bot_id', '=', 'bot.id')
            ->join('kelas', 'bot.kelas_id', '=', 'kelas.id')
            ->join('mapel', 'bot.mapel_id', '=', 'mapel.id')
            ->where('bot.id', $id)
            ->get();
        // dd($listSiswa);
        return view('pages.detailbot', compact('dataBot', 'listSiswa'));
    }

    public function deleteBot($id)
    {
        $bot = Bot::find($id);
        $bot->delete();

        return redirect('/chatbot')->with('success', 'Berhasil menghapus bot terpilih');
    }

    public function addQuestion($id)
    {
        $group = Groups::all();
        $kuis = Kuis::find($id);
        return view('pages.addquestion', compact('group', 'kuis'));
    }

    public function addGroupSoal()
    {
        return view('pages.addgroup');
    }

    public function createGroups(Request $request)
    {
        $group = new Groups();
        $group->name = $request->name;
        $group->save();

        return redirect()->back()->with('success', 'Data grup baru berhasil ditambahkan !');
    }

    public function createQuestion(Request $request)
    {
        $question = new Question();
        $question->question_text = $request->isiSoal;
        $question->kuis_id = $request->kuis_id;
        $question->save();
        // dd($question);

        return redirect()->back()->with('success', 'Soal Baru berhasil ditambahkan');
    }

    public function configQuiz($id)
    {
        $questions = DB::table('questions')
            ->where('kuis_id', $id)
            ->get();

        $kuis = Kuis::find($id);

        // dd($quiz);

        return view('pages.configquiz', compact('questions', 'kuis'));
    }

    public function detailSoal($id)
    {
        $question = Question::find($id);
        $options = DB::table('options')->join('questions', 'options.question_id', '=', 'questions.id')->where('question_id', $id)->get();
        // dd($options);
        return view('pages.detailSoal', compact('question', 'options'));
    }

    public function addOpsi($id)
    {
        $soal = Question::find($id);
        // dd($soal);

        return view('pages.addOptions', compact('soal'));
    }

    public function createOption(Request $request)
    {
        $option = new Option();
        $option->option_text = $request->isiOpsi;
        $option->question_id = $request->idSoal;
        $option->status = $request->status;
        $option->save();

        // dd($option);

        return redirect()->back()->with('success', 'Data Opsi Baru telah ditambahkan');
    }

    function divideTextIntoSentences($text)
    {
        // Merge paragraphs into one string
        $mergedText = preg_replace('/\n{2,}/', ' ', $text);

        // Split the merged text into sentences
        $sentences = preg_split('/(?<=[.?!])\s+(?=[a-zA-Z])/u', $mergedText);

        $wordsPerSentence = [];
        foreach ($sentences as $sentence) {
            $words = preg_split('/\s+/', $sentence, -1, PREG_SPLIT_NO_EMPTY);
            $wordsPerSentence[] = $words;
        }

        $tokenized = $wordsPerSentence;

        return $tokenized;
    }

    public function tokenizing($text)
    {
        $words = array_filter(preg_split('/\s+/', mb_strtolower($text)));

        return $words;
    }

    public function stopWords()
    {
        $filePath = 'assets/other/stopwordbahasabackup.txt';
        // Assuming you have an array of Indonesian stopwords
        $stopwords = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Convert the array of stopwords to a set for faster lookup
        return $stopwords;
    }

    function filterStopwords($data, $stopwordsSet)
    {
        $filteredWords = array_values(array_diff($data, $stopwordsSet));

        return $filteredWords;
    }

    public function removeSw($sentences, $stopwordsSet)
    {
        $sw_removed = [];
        foreach ($sentences as $sentence) {
            // Tokenize sentence into words
            $words = preg_split('/\s+/', $sentence);

            // Remove stopwords
            $filtered_words = array_diff($words, $stopwordsSet);

            // Reconstruct the sentence
            $filtered_sentence = implode(' ', $filtered_words);

            // Add the filtered sentence to the result array
            $sw_removed[] = $filtered_sentence;
        }
        return $sw_removed;
    }


    public function sastrawi($sw_removed)
    {
        // Create stemmer
        $factory = new StemmerFactory();
        $stemmer = $factory->createStemmer();

        // Assuming $sw_removed contains the array of sentences without stopwords
        $stemmedSent = [];
        foreach ($sw_removed as $sentence) {
            $stemmedSentence = $stemmer->stem($sentence);
            $stemmedSent[] = $stemmedSentence;
        }

        // Output the array of stemmed sentences
        return $stemmedSent;
    }

    public function nLP()
    {
        $text = "Sejarah awal mula kerajaan atau kesultanan Ternate sebagian besarnya bersumber dari legenda dan hikayat. Salah satu hikayat yang terkenal luas dan banyak dijadikan rujukan ialah Sejarah Ternate yang ditulis oleh Naidah, yang diterjemahkan oleh P Van der Crab, Residen Ternate 1863-1864 dan diterbitkan pada tahun 1878. Sumber lainnya ialah catatan-catatan yang ditulis oleh Rijali, seorang ulama Maluku asal Hitu yang dihimpun oleh Francois Valentijn dalam bukunya Ound en Neeuw Oost Indie.[7]
        Asal usul komunitas atau penduduk Ternate disebutkan oleh sumber-sumber tersebut, berasal dari Pulau Halmahera yang melakukan eksodus atau migrasi besar-besaran ke beberapa pulau kecil di bagian barat Pulau Halmahera termasuk ke Ternate, disebabkan terjadinya pergolakan dan konflik politik di Jailolo (Gilolo), di Pulau Halmahera pada tahun 1250.
        Para migran pertama yang mendarat dan bermukim di Ternate tahun 1250 adalah komunitas Tobona yang dipimpin oleh Momole Guna. Momole adalah sebutan kepada pemimpin atau kepala marga, klan atau komunitas.
        Pada tahun 1254 migran kedua tiba dan bermukim di Foramadiyahi yang dipimpin oleh Mole Matiti. Menyusul kemudian migran ketiga yang bermukim di Sampala yang dipimpin oleh Momole Ciko/Siko, kedua permukiman komunitas terakhir ini dibangun tidak jauh dari pantai. Sampala bahkan terletak di tepi pantai. Dalam sumber sejarah lain menyebutkan terdapat 4 (empat) komunitas atau klan awal di Ternate, yakni masing-masing: Komunitas atau Klan Tobona, yang mendiami kawasan lereng Gamalama bagian Selatan (kini Kelurahan Foramadiyahi): Tubo yang mendiami kawasan lereng Gamalama bagian Utara; Tabanga, yang mendiami kawasan pesisir Utara Pulau Ternate, dan Komunitas atau Klan Toboleu, yang mendiami kawasan pesisir Timur Pulau Ternate.
        Komunitas atau klan awal inilah yang pertama-tama mengadakan hubungan dengan para pedagang yang datang dari beberapa belahan dunia untuk mencari cengke dan rempah lainnya.
        Seiring waktu, penduduk pun kian bertambah dan semakin heterogen dengan bermukimnya pedagang Arab, Cina, Jawa, dan Melayu. aktivitas perdagangan kian ramai. Ancaman pun sering datang dari para perompak. Pada tahun 1257, Momole Guna, pemimpin Klan Tobona memprakarsai musyawarah untuk membentuk komunitas yang lebih kuat dan mengangkat seorang pemimpin sebagai Kolano atau Raja. Hasil musyawarah menetapkan Momole Ciko, pimpinana Klan Sampala sebagai Kolano Ternate pertama dengan gelar Baab Mansyur Malamo (1257-1272). Pusat Kerajaan ditetapkan di Sampala. Kawasan ibu kota terletak di pantai Barat Pulau Ternate. Peristiwa ini disebut sebagai Tara No Ate yang artinya Turun dan Merangkul. Tara No Ate adalah cikal bakal penyebutan nama Ternate. Sementara ibu kota kerajaan di Sampala kemudian disebut Gam Lamo yang artinya kampung atau perkampungan besar. Gam Lamo adalah cikal bakal penyebutan nama Gamalama.[7]
        Sejak era itu, Kerajaan Ternate berperan penting di kawasan Maluku Utara sampai abad ke-17. Dalam catatan sejarah Kesultanan Ternate atau juga dikenal dengan Kerajaan Gapi, adalah salah satu kerajaan tertua dan sangat berpengaruh di nusantara.
        Setelah Mansyur Malamo (1257-1272), Kolano Ternate dijabat oleh Kaiicil Jamin (1272-1284). Kaiicil adalah sebutan untuk seorang Pangeran, atau putra Kolano. Setelah Kaiicil Jamin, Kolano Ternate dijabat oleh Kaiicil Siale (1284-1298). Pada masa Kaiicil Siale, ibu kota kerajaan dipindahkan dari Sampala ke Foramadiyahi. Setelah itu, Siale digantikan secara berturut-turut oleh Kaiicil Kamalu (298-1304) dan Kaiicil Ngara Malamo (1304-1317).
        Di bawah kepemimpinan Kaiicil Ngara Malamo, Ternate memulai ekspansi teritorialnya. Kaiicil Ngara Malamo adalah peletak dasar politik ekspansi Kerajaan Ternate. Politik ekspansi inilah yang mengantarkan Ternate menjadi Kerajaan paling besar, paling kuat dan paling berpengaruh dalam jajaran kerajaan-kerajaan Maluku pada masa-masa selanjutnya, terutama dari akhir abad ke-14 hingga awal abad ke-16. Namun, memasuki abad ke-16, pamor Ternate sebagai kerajaan paling tangguh mulai merosot.
        Kaiicil Ngara Malamo diganti oleh Patsyaranga Malamo (1317-1322), kemudian Sida Arif Malamo (1322-1331). Di masa Kolano Sida Arif Malamo, Ternate telah ramai didatangi oleh pedagang mancanegara seperti pedagang dari Cina, Arab dan Gujarat, juga pedagang dari nusantara seperti Jawa, Malaka, dan Makassar.
        Ternate di bawah Kolano Sida Arif Malamo berkembang menjadi bandar perdagangan terbesar dan utama di Maluku. Aktivitas perdagangan antar bangsa kala itu berpusat di Pelabuhan Talangame atau sekarang dikenal dengan nama Pelabuhan Bastiong. Ternate pun telah memiliki pasar dengan fasilitas yang memadai, tempat bertemunya pedagang lokal, pedagang mancanegara dan pedagang nusantara.
        Armada-armada perdagangan antar bangsa datang ke pelabuhan ini terutama mencari rempah, komoditas penting dalam perdagangan pasar Internasional saat itu yang menempatkan gugusan kepulauan ini menjadi ajang lalu lintas niaga yang sibuk. Pesatnya perdagangan rempah-rempah para Raja Maluku pun saling bersaing memantapkan posisinya masing-masing sehingga tidak jarang menimbulkan konflik di antara mereka. Kolano Sida Arif Malamo pun mengambil prakarsa mengadakan pertemuan raja-raja se-Maluku untuk membentuk persekutuan bersama yang dikenal dengan Persekutuan Moti (Motir Verbond), atau juga dikenal sebagai persekutuan Moloku Kie Raha (Empat Kerajaan Maluku).
        Musyawarah persekutuan itu melahirkan keputusan antara lain penyeragaman bentuk-bentuk kelembagaan kerajaan-kerajaan di Maluku dan penentuan peringkat kerajaan peserta musyawarah. Jailolo ditetapkan sebagai kerajaan yang menempati peringkat pertama dalam senioritas, menyusul Ternate, Tidore dan bacan. disepakati pula pembagian peran masing-masing kerajaan. Raja Ternate berperan sebgai Alam Makolano, penjaga dan penjamin stabilitas perdagangan dan urusan keduniaan. Raja Bacan berperan sebagai Dehe Makolano, penjaga perbatasan. Raja Tidore berperan sebagai Kie Makolano, penjaga dan penjamin keamanan dalam negeri. Raja Jailolo berperan sebagai Jiko Makolano, penjaga serangan dan ancaman dari luar.
        Manfaat persekutuan ini adalah sejak 1322 Maluku mengalami masa aman dan damai. Berhasil meredam sementara waktu ambisi, permusuhan dan ekspansi para anggota persekutuan. Rakyat Maluku menikmati suasana aman dan damai selama kurang lebih 20 tahun. Tetapi perdamaian yang ditegakkan dengan susah payah itu sirna ketika Kolano Tulu Lamo naik tahta sebagai Kolano Ternate (1334-1347). Ia secara sepihak membatalkan hasil persekutuan Moti dan menyatakan hasil persekutuan tersebut tidak lagi mengikat bagi Ternate. Tulu Lamo menempatkan Ternate pada peringkat teratas sebagai yang tertua. Keputusan itu mendapat reaksi keras dari ketiga kerajaan lainnya. Ia juga menyerang makian, bandar niaga rempah terbesar kedua di Maluku setelah Ternate. Ternate setelah kepemimpinan Kolano Tulu Lamo terus menyerah beberapa daerah sekitarnya. Sula diserbu oleh Kolano Ngolo Macahaya (1350-1375), menyusul Jailolo diserang oleh Kolano Marhum (1465-1486). Kemudian berbagai penaklukan dilakukan Ternate atas Maluku Tengah, Seram Barat dan Buru.
        Naiknya Kolano Zainal Abidin (1468-1500) menandai berakhirnya era kerajaan dan berganti ke era kesultanan. Gelar Kolano atau Raja berubah menjadi Sultan. Sultan Zainal Abidin memproklamirkan Islam sebagai agama resmi Kesultanan Ternate, dan pembentukan lembaga Jolebe, lembaga baru dalam struktur kesultanan yang membantu sultan dalam urusan-urusan keagamaan Islam. Struktur baru Kesultanan Ternate ini memengaruhi kerajaan-kerajaan lain di Maluku. Struktur tersebut segera diadopsi oleh Tidore, Bacan dan Jailolo.
        Sultan Zainal Abidin diganti oleh Sultan Bayan Sirrullah (1500-1522), kemudian diganti oleh Sultan Hidayat alias Deyalo. Pengangkatan Sultan Hidayat yang usianya belum akil baligh, sehingga ibunya Boki Rainha Nukila diangkat sebagai Mangkubumi dan Taruwese diangkat sebagai wakil Sultan (1529-1530). Kemudian berturut-turut digantikan oleh Sultan Abuhayat alias Boheyat (1530-1532), Sultan Tabariji (1532-1535), Sultan Khairun Jamil (1535-1570), kemudian Sultan Baabullah Datu Syah (1570-1683).
        Ternate di masa Sultan Baabullah mencapai penaklukan yang spektakuler. Wilayah Kesultanan ternate membentang dari Mindanao di Utara sampai Bima di Selatan dan dari Makassar di Barat sampai Banda di Timur. Karena itu, Baabullah, Sultan Ternate terbesar ini dikenal sebagai penguasa atas 72 pulau yang seluruhnya berpenghuni.
        Di masa pemerintahan Sultan Baabullah, Ternate tampil sebagai kesultanan paling berpengaruh dalam politik maupun militer di kawasan Timur Nusantara. Baabullah menurut sebuah sumber, mampu mengerahkan 90700 tentara bila diperlukan. Kontributor terbesar - di atas 10000 - pasukan ini adalah dari Veranullah dan Ambon (15000 tentara), Teluk Tomini (12000 tentara), Batu Cina dan sekitarnya termasuk Halmahera Utara (10000 tentara), Gorontalo dan Limboto (10000 tentara) serta Yafera (10000 tentara). Penyumbang pasukan tersedikit adalah dari Moti dan Hiri, masing-masing 300 tentara.
        Keberhasilan Sultan Baabullah tidak terlepas dari kecakapan sejumlah panglima dan komandan tentara, seperti Kapita Laut Kapalaya dan Rubohongi. Kapalaya adalah penakluk pantai timur Sulawesi, khususnya Buton, dan Rubohongi adalah penakluk Maluku Tengah. Enam tahun setelah bertahta, Baabullah telah menguasai pulau-pulau di Ambon, Hoamoal di Pulau Seram, Buru, Manipa, Ambalau, Kelang dan Buano. Empat tahun setelah itu, ia juga menguasai desa-desa sepanjang pantai timur Sulawesi, Banggai, Tobongku, Buton, Tiboro, dan Pangasani. Setelah itu giliran Makassar dan Selayar datang ke Ternate. Tahun kedatangannya merupakan awal dari monopoli rempah-rempah Kompeni di Ternate.";

        // $data = $this->divideTextIntoSentences($text);
        $tokenized = $this->divideTextIntoSentences($text);
        $flattenedArray = array_merge(...$tokenized);
        $resultArray = array_map('strval', $flattenedArray);
        $stopwordsSet = $this->stopWords();
        $sentences = preg_split('/(?<=[.?!])\s+(?=[A-Z])/u', $text);

        // $filteredWords = $this->filterStopwords($wordsPerSentence, $stopwordsSet);
        // $result = $this->filterStopwords($data, $stopwordsSet);

        $sw_removed = $this->removeSw($sentences, $stopwordsSet);

        $stemmedSent = $this->sastrawi($sw_removed);
        $total_count = count($tokenized);

        // $tfidf = $this->calculateTFIDF($stemmedSent, $sentences, $tokenized);

        // Return the array of sentences with stopwords removed
        return json_encode($stemmedSent);
    }

    function calculateTFIDF($stemmedSent, $sentences, $tokenized)
    {
        // Calculate term frequency (TF) for each document
        $termFrequency = [];
        $totalDocs = count($stemmedSent);

        foreach ($stemmedSent as $document) {
            $tokens = $this->tokenizing($document);
            $docWordCount = array_count_values($tokens);

            $tf = [];
            foreach ($docWordCount as $word => $count) {
                $tf[$word] = $count / count($tokens);
            }

            $termFrequency[] = $tf;
        }

        // Calculate inverse document frequency (IDF)
        $idf = [];
        $words = [];
        foreach ($stemmedSent as $document) {
            $words = array_unique(array_merge($words, $tokenized));
        }

        foreach ($words as $word) {
            $wordCount = 0;
            foreach ($stemmedSent as $document) {
                if (stripos($document, $word) !== false) {
                    $wordCount++;
                }
            }

            $idf[$word] = log($totalDocs / ($wordCount + 1)); // Adding 1 to avoid division by zero
        }

        // Calculate TF-IDF
        $tfidf = [];
        foreach ($termFrequency as $tf) {
            $tfidfDoc = [];
            foreach ($tf as $word => $tfValue) {
                $tfidfDoc[$word] = $tfValue * $idf[$word];
            }
            $tfidf[] = $tfidfDoc;
        }

        return $tfidf;
    }



    public function getProfile($id)
    {
        $dataUser = User::find($id);
        $infoUser = DB::table('users')->join('guru', 'users.guru_id', '=', 'guru.id')->where('users.id', $id)->first();

        return view('pages.profile', compact('dataUser', 'infoUser'));
    }

    public function updateDataProfile(Request $request, $id)
    {
        $data = User::find($id);
        $data->email = $request->email;
        // $data->password =
    }

    public function createBotOption(Request $request)
    {
    }
}
