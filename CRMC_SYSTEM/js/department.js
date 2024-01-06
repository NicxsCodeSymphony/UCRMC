let btn = document.querySelector('#btn')
        let sidebar = document.querySelector('.sidebar')

        btn.onclick = function () {
            sidebar.classList.toggle('active');
        };

        // Update current time
        function updateCurrentTime() {
            const currentDate = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'long' };
            const formattedDate = new Intl.DateTimeFormat('en-US', options).format(currentDate);
            document.getElementById('current-time').textContent = formattedDate;
        }

        // Call the function on load
        updateCurrentTime();

        function openPopup() {
    document.getElementById('popupContainer').style.display = 'flex';
}

function closePopup() {
    document.getElementById('popupContainer').style.display = 'none';
}

function submitForm() {
    // Add your form submission logic here
    // You can retrieve the department name using document.getElementById('departmentName').value
    // For simplicity, let's just close the popup for now
    closePopup();
}

function triggerLogoInput() {
    document.getElementById('logoInput').click();
}

// Handle Logo Input Change
document.getElementById('logoInput').addEventListener('change', handleLogoInputChange);

function handleLogoInputChange() {
            const logoInput = document.getElementById('logoInput');
            const addLogoPreview = document.getElementById('addLogoPreview');

            if (logoInput.files.length > 0) {
                const selectedImage = URL.createObjectURL(logoInput.files[0]);
                addLogoPreview.src = selectedImage;
                addLogoPreview.style.display = 'block'; // Show the image
            }
        }

        
        // Function to show the custom alert
        function showCustomAlert() {
            const customAlert = document.getElementById('customAlert');
            customAlert.style.display = 'block';

            // Hide the alert after 5 seconds
            setTimeout(() => {
                customAlert.style.display = 'none';
            }, 5000);
        }


        function deleteDepartment(departmentID) {
        if (confirm("Are you sure you want to delete this department?")) {
            // Send an AJAX request to delete_department.php
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "department.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload the page after successful deletion
                    location.reload();
                }
            };

            // Send the department ID to the server
            xhr.send("departmentID=" + departmentID);
        }
    }


    