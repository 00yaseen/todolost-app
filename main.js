//this is for navbar, it wil work on mobile size 
document.addEventListener("DOMContentLoaded", () => {
    const burger = document.querySelector(".navbar-burger");
    const menu = document.querySelector(`#${burger.dataset.target}`);

    burger.addEventListener("click", () => {
      burger.classList.toggle("is-active");
      menu.classList.toggle("is-active");
    });
  });

//taske deletion
document.addEventListener("DOMContentLoaded", () => {
    const checkboxes = document.querySelectorAll(".delete-checkbox");
    const deleteButtons = document.querySelectorAll(".manual-delete");

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            const card = this.closest(".card");
            if (this.checked) {
                card.classList.add("task-completed");

                setTimeout(() => {
                    if (document.body.contains(card)) { 
                        card.remove();
                        console.log("Task card removed after 24 hours.");
                    }
                }, 86400000);
            } else {
                card.classList.remove("task-completed");
            }
        });
    });

    // Manually delete task
    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            const card = this.closest(".card");
            card.remove();
            console.log("Task card removed manually.");
        });
    });
});

 