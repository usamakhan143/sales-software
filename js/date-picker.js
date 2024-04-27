// Function to initialize datepicker for a given input field
const initializeDatepicker = (inputField) => {
    const datepicker = inputField.nextElementSibling;
    const dateInput = inputField;
    const yearInput = datepicker.querySelector(".year-input");
    const monthInput = datepicker.querySelector(".month-input");
    const cancelBtn = datepicker.querySelector(".cancel");
    const applyBtn = datepicker.querySelector(".apply");
    const nextBtn = datepicker.querySelector(".next");
    const prevBtn = datepicker.querySelector(".prev");
    const dates = datepicker.querySelector(".dates");

    let selectedDate = new Date();
    let year = selectedDate.getFullYear();
    let month = selectedDate.getMonth();

    // Show datepicker when input field is clicked
    dateInput.addEventListener("click", () => {
        datepicker.hidden = false;
    });

    // Hide datepicker when cancel button is clicked
    cancelBtn.addEventListener("click", () => {
        datepicker.hidden = true;
    });

    // Handle apply button click event
    applyBtn.addEventListener("click", () => {
        dateInput.value = selectedDate.toLocaleDateString("en-US", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
        });
        datepicker.hidden = true;
    });

    // Handle next month navigation
    nextBtn.addEventListener("click", () => {
        if (month === 11) year++;
        month = (month + 1) % 12;
        displayDates();
    });

    // Handle previous month navigation
    prevBtn.addEventListener("click", () => {
        if (month === 0) year--;
        month = (month - 1 + 12) % 12;
        displayDates();
    });

    // Handle month input change event
    monthInput.addEventListener("change", () => {
        month = monthInput.selectedIndex;
        displayDates();
    });

    // Handle year input change event
    yearInput.addEventListener("change", () => {
        year = yearInput.value;
        displayDates();
    });

    // Update year and month inputs
    const updateYearMonth = () => {
        monthInput.selectedIndex = month;
        yearInput.value = year;
    };

    // Handle date click event
    const handleDateClick = (e) => {
        const button = e.target;
        const selected = dates.querySelector(".selected");
        selected && selected.classList.remove("selected");
        button.classList.add("selected");
        selectedDate = new Date(year, month, parseInt(button.textContent));
    };

    // Render dates in the calendar interface
    const displayDates = () => {
        updateYearMonth();
        dates.innerHTML = "";

        // Display the last week of previous month
        const lastOfPrevMonth = new Date(year, month, 0);
        for (let i = 0;i <= lastOfPrevMonth.getDay();i++) {
            const text = lastOfPrevMonth.getDate() - lastOfPrevMonth.getDay() + i;
            const button = createButton(text, true, -1);
            dates.appendChild(button);
        }

        // Display the current month
        const lastOfMonth = new Date(year, month + 1, 0);
        for (let i = 1;i <= lastOfMonth.getDate();i++) {
            const button = createButton(i, false);
            button.addEventListener("click", handleDateClick);
            dates.appendChild(button);
        }

        // Display the first week of next month
        const firstOfNextMonth = new Date(year, month + 1, 1);
        for (let i = firstOfNextMonth.getDay();i < 7;i++) {
            const text = firstOfNextMonth.getDate() - firstOfNextMonth.getDay() + i;
            const button = createButton(text, true, 1);
            dates.appendChild(button);
        }
    };

    // Create button for each date
    const createButton = (text, isDisabled = false, type = 0) => {
        const currentDate = new Date();
        let comparisonDate = new Date(year, month + type, text);
        const isToday =
            currentDate.getDate() === text &&
            currentDate.getFullYear() === year &&
            currentDate.getMonth() === month;
        const selected = selectedDate.getTime() === comparisonDate.getTime();

        const button = document.createElement("button");
        button.textContent = text;
        button.disabled = isDisabled;
        button.classList.toggle("today", isToday);
        button.classList.toggle("selected", selected);
        return button;
    };

    // Initialize datepicker
    displayDates();
};

// Initialize datepicker for first input field
initializeDatepicker(document.getElementById("combine-date"));

// Initialize datepicker for second input field
initializeDatepicker(document.getElementById("due-date"));
