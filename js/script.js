function checkboxChangeColor() {
    var checkbox = document.getElementsByName("skill");
    var container = document.getElementsByClassName("skill");

    for (var check = 0; check < checkbox.length; check++) {
        if (checkbox[check].checked) {
            container[check].style.backgroundColor = "var(--red)";
        }
        else {
            container[check].style.backgroundColor = "var(--darker-gray)";
        }
    }
}

function cardColor(){
document.querySelectorAll('.card').forEach(card => {
    const checkbox = card.querySelector('input[type="checkbox"]');
    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            card.style.backgroundColor = "var(--red)";
            card.querySelector('p').style.color = "white";
        } else {
            card.style.backgroundColor = "var(--darker-gray)";
            card.querySelector('p').style.color = "rgb(103, 103, 103)";
        }
    });
});}


function convertToIndicNumbers(className) {
    const elements = document.querySelectorAll(`.${className}`);
  
    elements.forEach(element => {
      const textContent = element.textContent;
      let indicNumbers = "";
      for (let i = 0; i < textContent.length; i++) {
        const char = textContent.charAt(i);
        if (/\d/.test(char)) {
          const digit = parseInt(char, 10); // Convert digit to number
          indicNumbers += String.fromCharCode(digit + 1632);
        } else {
          indicNumbers += char; // Keep other characters unchanged
        }
      }
      element.textContent = indicNumbers;
    });
  }
  
  
  