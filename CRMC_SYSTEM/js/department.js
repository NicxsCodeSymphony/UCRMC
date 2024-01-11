let btn = document.querySelector('#btn')
        let sidebar = document.querySelector('.sidebar')

        btn.onclick = function () {
            sidebar.classList.toggle('active');
        };

        function updateDateTime() {
            var currentDate = new Date();
            var options = { weekday: 'long', day: 'numeric', month: 'long' };
            var formattedDate = currentDate.toLocaleDateString('en-US', options);
            
            var hours = currentDate.getHours();
            var minutes = currentDate.getMinutes();
            var seconds = currentDate.getSeconds();
            
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // The hour '0' should be '12'
            
            var formattedTime = hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds + ' ' + ampm;
    
            document.getElementById('current-time').textContent = formattedDate + ', ' + formattedTime;
        }
    
        // Call the function initially
        updateDateTime();
    
        // Update every second
        setInterval(updateDateTime, 1000);

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


    