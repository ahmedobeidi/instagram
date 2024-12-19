const addButton = document.getElementById('addButton');
const addForm = document.getElementById('addForm');

addButton.addEventListener("click", handleButtonClick);

let cliked = false;

function handleButtonClick() {
    if (!cliked) {
        addForm.classList.add("block");
        addForm.classList.remove("hidden");
        cliked = true;
    }
    else {
        addForm.classList.remove("block");
        addForm.classList.add("hidden");
        cliked = false;
    }
}