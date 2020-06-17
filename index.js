
let ele = document.querySelectorAll("li");


ele.forEach(button => {

    button.addEventListener('click', function () {

        ele.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

    });


});

