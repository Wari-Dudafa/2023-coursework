let textArea = document.getElementById("textbox");
let characterCounter = document.getElementById("char_count");
let button = document.getElementById("commentbutton");
button.style.display = "none";




const countCharacters = () => {
        let numOfEnteredChars = textArea.value.length;
    let counter = numOfEnteredChars;
    characterCounter.textContent = counter;

      if (counter > 250) {
        characterCounter.style.color = "red";
        button.style.display = "none";
    } else if (counter < 249) {
        characterCounter.style.color = "green";
        button.style.display = "block";
    }
};

textArea.addEventListener("input", countCharacters);