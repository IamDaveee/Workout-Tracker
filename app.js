const numberInput = document.getElementById("number");
const exercisesContainer = document.getElementById("right");

let numberOfEx = 0;

numberInput.oninput = () => {
    // Clear existing exercise fields
    exercisesContainer.innerHTML = `
        <fieldset class="exercisesContainer">
            <legend><h3>Exercises</h3></legend>
        </fieldset>
    `;

    const numberOfExercises = parseInt(numberInput.value);
    for (let i = 1; i <= numberOfExercises; i++) {
        const exerciseFieldset = document.createElement("fieldset");
        exerciseFieldset.id = `exPair${i}`;
        const exerciseField = document.createElement("input");
        exerciseField.type = "text";
        exerciseField.name = `ex${i}`;
        exerciseField.className = "ex";
        exerciseField.placeholder = `Exercise ${i}`;

        const setsField = document.createElement("input");
        setsField.type = "number";
        setsField.name = `sets${i}`;
        setsField.className = "sets";
        setsField.placeholder = "Number of Sets";
        setsField.min = 1;
        setsField.id = `ex${i}`;

        const extraContainer=document.createElement("div")
        extraContainer.className=`extraConatiner${i}`;

        exerciseFieldset.appendChild(exerciseField);
        exerciseFieldset.appendChild(setsField);
        exerciseFieldset.appendChild(extraContainer);
        exercisesContainer.appendChild(exerciseFieldset);

        numberOfEx = i;


        // Attach event listener to the sets field
        setsField.oninput = () => {
            // Clear previous additional fields
            extraContainer.innerHTML = ``;

            const numberOfExtraFields = parseInt(setsField.value);
            for (let j = 1; j <= numberOfExtraFields; j++) {

                const extraFieldSet=document.createElement("fieldset")
                extraFieldSet.className = "weight_set"

                const extraWeight = document.createElement("input");
                extraWeight.type = "number";
                extraWeight.name = `set${j}_w${j}`;
                extraWeight.className = "weight";
                extraWeight.placeholder = `Weight - ${j}`;
                extraWeight.min = 1;

                const extraReps = document.createElement("input");
                extraReps.type = "number";
                extraReps.name = `set${j}_r${j}`;
                extraReps.className = "reps";
                extraReps.placeholder = `Reps - ${j}`;
                extraReps.min = 1;

                extraFieldSet.appendChild(extraWeight);
                extraFieldSet.appendChild(extraReps);
                extraContainer.appendChild(extraFieldSet);
            }
        };
    };
}