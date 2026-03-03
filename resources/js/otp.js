const inputs = document.querySelectorAll('.otp-inputs input');
        inputs.forEach((input, index) => {
            input.addEventListener('keyup', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                if (e.key === "Backspace" && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

    
