function translit(name, uri) {
    let str = document.getElementById(name).value;
    let space = '-';
    let link = '';
    let transl = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
        'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
        'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
        'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': space,
        'ы': 'y', 'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya'
    }
    if (str !== '')
        str = str.toLowerCase();

    for (let i = 0; i < str.length; i++){
        if (/[а-яё]/.test(str.charAt(i))){ // заменяем символы на русском
            link += transl[str.charAt(i)];
        } else if (/[a-z0-9]/.test(str.charAt(i))){ // символы на анг. оставляем как есть
            link += str.charAt(i);
        } else {
            if (link.slice(-1) !== space) link += space; // прочие символы заменяем на space
        }
    }
    document.getElementById(uri).value = link;
}
