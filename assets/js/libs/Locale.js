/**
 * Translate words function
 * Uses global variable "Locale"
 * @param word
 * @return {*}
 */
module.exports = function(word){

    const trans = {
        ua:{
            "Selecting files":"Вибір  файлів",
            "Uploading":"Загрузка",
            "Actions":"Дії",
            "Copy link ( direct )":"Копіювати ссилку",
            "Copy file id":"Копіювати id файла",
            "Delete":"Видалити",
            "Error":"Помилка",
            "Download":"Скачати",
            "Nothing not found":"Нічого не знайдено",
            'Here yor id, you can copy it by clicking ctrl + c':"Ось ваш id, ви можете скопіювати його натиснувши ctrl + c",
            'Here yor link, you can copy it by clicking ctrl + c':"Ось ваша ссилка, ви можете скопіювати її натиснувши ctrl + c",
            'Search!':"Пошук",
            'Id copied':"Id скопійовано",
            'Link copied':"Посилання скопійовано",
            'Close':'Закрити'
        },
        de:{

        },
        en:{

        }
    };

    return typeof trans[Locale][word] !== "undefined" ? trans[Locale][word] : word;

};