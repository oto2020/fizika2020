class myCalc {

    helloWorld() {
        console.log('Hello myLib');
    }

    // если всё ок, то возвращается пустой inputError
    validateInput(value)
    {
        let inputError = '';
        // если содержатся какие-либо символы кроме цифр, минуса и точки
        if (value.toString().match(/[^0-9\.\-]+/))
            inputError = 'Недопустимый символ';

        // если в глобальном поиске точек найдётся больше двух
        let matches = value.toString().match(/\./g);
        if (matches!==null && matches.length > 1)
            inputError = 'Больше одной точки';

        // если минус и будет, то должен он быть только один раз
        matches = value.toString().match(/\-/g);
        if (matches!==null && matches.length > 1)
            inputError = 'Больше одного знака минус';

        if (matches!==null && value.toString().indexOf("-")!==0)
            inputError = 'Знак минус находится не на своём месте';

        return inputError;
    }


}

