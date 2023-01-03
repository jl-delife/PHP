let inputField = document.querySelector("input");

let usedIds = [];
let activeIds = [];
let inputFieldValue = "";

checkExistingIds();

inputField.addEventListener("keypress", function (e) {
    if (e.key === "Enter" && inputField.value !== "") {
        inputFieldValue = [inputField.value];
        createNote();
        inputField.value = "";
    }
});

function createNote(value = [""]) {
    value.forEach((item) => {
        let newArticle = document.createElement("li");

        if (value == "") {
            activeIds.push({
                id: usedIds.length + 1,
                value: inputFieldValue,
                completed: false,
            });

            newArticle.innerText = inputFieldValue;
            newArticle.id = usedIds.length + 1;

            usedIds.push(usedIds.length + 1);
            updateLS();
        }

        if (value != "") {
            newArticle.innerText = item.value;
            newArticle.id = item.id;

            if (item.completed == true) {
                newArticle.classList.add("completed");
            }
        }

        newArticle.addEventListener("contextmenu", () => {
            newArticle.remove();
            let articleCounter = document.querySelectorAll("li").length;

            if (articleCounter == 0) {
                document.querySelector("div").style.display = "block";
            }

            let elem = activeIds.find((element) => element.id == newArticle.id);

            let indexElem = activeIds.indexOf(elem);
            activeIds.splice(indexElem, 1);
            updateLS();
        });

        newArticle.addEventListener("click", () => {
            newArticle.classList.toggle("completed");
            let elem = activeIds.find((element) => element.id == newArticle.id);
            let indexElem = activeIds.indexOf(elem);

            if (newArticle.classList.contains("completed")) {
                activeIds[indexElem].completed = true;
            } else {
                activeIds[indexElem].completed = false;
            }
            updateLS();
        });

        document.querySelector("ul").prepend(newArticle);
        document.querySelector("div").style.display = "none";
    });
}

function checkExistingIds() {
    if (
        localStorage.getItem("activeIds") &&
        localStorage.getItem("usedIds") != null
    ) {
        usedIds = JSON.parse(localStorage.getItem("usedIds"));
        activeIds = JSON.parse(localStorage.getItem("activeIds"));
        createNote(activeIds);
    }
}

function updateLS() {
    localStorage.setItem("usedIds", JSON.stringify(usedIds));
    localStorage.setItem("activeIds", JSON.stringify(activeIds));
}

document.oncontextmenu = () => {
    return false;
};
