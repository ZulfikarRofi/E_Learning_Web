const ul = document.querySelector('ul'),
input = ul.querySelector('input');

function addSelect(e)
{
    if(e.key == "Enter")
    {
        let select = e.target.value.replace(/\s+/g, '  ');
        if(select.length > 1 && !select.includes(select))
        console.log(e.target.value)
    }
}

input.addEventListener("keyup", addSelect);
