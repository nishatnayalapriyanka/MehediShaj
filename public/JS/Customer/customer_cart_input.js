function incrementValue(inputName) {
    var input = document.querySelector('input[name="' + inputName + '"]');
    var currentValue = parseInt(input.value);
    if (currentValue < parseInt(input.getAttribute('max'))) {
        input.value = currentValue + 1;
    }
}

function decrementValue(inputName) {
    var input = document.querySelector('input[name="' + inputName + '"]');
    var currentValue = parseInt(input.value);
    if (currentValue > parseInt(input.getAttribute('min'))) {
        input.value = currentValue - 1;
    }
}
