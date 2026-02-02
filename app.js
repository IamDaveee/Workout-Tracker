const numberInput = document.getElementById("number");
const exercisesContainer = document.getElementById("right");

// How many exercise blocks currently exist in the DOM
let numberOfEx = 0;

function createExerciseBlock(i) {
  const exerciseFieldset = document.createElement("fieldset");
  exerciseFieldset.id = `exPair${i}`;
  exerciseFieldset.className = "exPair";

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
  setsField.id = `ex${i}numberOfSets`;

  const extraContainer = document.createElement("div");
  extraContainer.className = `extraConatiner${i} extraContainer${i}`;

  // --- helper now correctly includes exercise index in names ---
  const createSetRow = (i, j) => {
    const extraFieldSet = document.createElement("fieldset");
    extraFieldSet.className = "weight_set";

    const extraWeight = document.createElement("input");
    extraWeight.type = "number";
    extraWeight.name = `set${i}_w${j}`;   // e.g. set1_w1
    extraWeight.className = "weight";
    extraWeight.placeholder = `Weight - ${j}`;
    extraWeight.min = 0;

    const extraReps = document.createElement("input");
    extraReps.type = "number";
    extraReps.name = `set${i}_r${j}`;     // e.g. set1_r1
    extraReps.className = "reps";
    extraReps.placeholder = `Reps - ${j}`;
    extraReps.min = 0;

    extraFieldSet.appendChild(extraWeight);
    extraFieldSet.appendChild(extraReps);
    return extraFieldSet;
  };

  setsField.addEventListener("input", () => {
    const desired = Math.max(0, parseInt(setsField.value, 10) || 0);
    const existing = extraContainer.querySelectorAll(".weight_set").length;

    if (desired > existing) {
      for (let j = existing + 1; j <= desired; j++) {
        extraContainer.appendChild(createSetRow(i, j)); // <-- pass i, j
      }
    }

    if (desired < existing) {
      for (let j = existing; j > desired; j--) {
        const last = extraContainer.lastElementChild;
        if (last) extraContainer.removeChild(last);
      }
    }
  });

  exerciseFieldset.appendChild(exerciseField);
  exerciseFieldset.appendChild(setsField);
  exerciseFieldset.appendChild(extraContainer);
  return exerciseFieldset;
}

function syncExerciseBlocks(desiredCount) {
  const count = Math.max(1, desiredCount | 0); // always keep at least one

  // Append missing blocks without touching existing ones
  for (let i = numberOfEx + 1; i <= count; i++) {
    exercisesContainer.appendChild(createExerciseBlock(i));
  }

  // Remove extra blocks from the end (preserve earlier inputs)
  for (let i = numberOfEx; i > count; i--) {
    const toRemove = document.getElementById(`exPair${i}`);
    if (toRemove) exercisesContainer.removeChild(toRemove);
  }

  numberOfEx = count;
}

// Initialize on load — default to 1 exercise
window.addEventListener("DOMContentLoaded", () => {
  // Make sure the number input shows at least 1
  const startVal = parseInt(numberInput?.value, 10);
  if (!startVal || startVal < 1) {
    if (numberInput) numberInput.value = 1;
  }

  // If server already rendered some blocks, detect them
  numberOfEx = Array.from(document.querySelectorAll('fieldset[id^="exPair"]').values()).length;

  // Ensure we have as many blocks as the input says (or 1)
  syncExerciseBlocks(parseInt(numberInput?.value, 10) || 1);
});

// When the user changes the number, add/remove incrementally instead of rebuilding
if (numberInput) {
  numberInput.addEventListener("input", () => {
    const desired = parseInt(numberInput.value, 10) || 1;
    const clamped = Math.max(1, desired);
    if (clamped !== desired) numberInput.value = clamped; // reflect clamp in UI
    syncExerciseBlocks(clamped);
  });
}

let presetName=document.getElementById("preset")
presetName.onchange=()=>{
  
}