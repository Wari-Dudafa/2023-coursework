let textArea = document.getElementById("textbox");
let characterCounter = document.getElementById("char_count");
document.getElementById("buttons").innerHTML = "";

const countCharacters = () => {
        let numOfEnteredChars = textArea.value.length;
    let counter = numOfEnteredChars;
    characterCounter.textContent = counter;

      if (counter < 8) {
        characterCounter.style.color = "red";
    } else if (counter > 8) {
        characterCounter.style.color = "green";
        document.getElementById("buttons").innerHTML = "tada";
    }
};

textArea.addEventListener("input", countCharacters);
