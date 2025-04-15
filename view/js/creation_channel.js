function previewImage(event) {
    const preview = document.getElementById("imagePreview");
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = "block";
}

document.getElementById("createChannelForm").addEventListener("submit", function (e) {
    e.preventDefault();
    alert("add");

});
document.getElementById("createChannelForm").addEventListener("submit", function(event) {
    event.preventDefault();

    // Collecting form data
    var channelName = document.getElementById("channel-name").value;
    var channelDescription = document.getElementById("channel-description").value;
    var channelImage = document.getElementById("channel-image").files[0];

    // Create FormData object to send the data
    var formData = new FormData();
    formData.append("channel-name", channelName);
    formData.append("channel-description", channelDescription);
    if (channelImage) {
        formData.append("channel-image", channelImage);
    }

    $.ajax({
        url: "../controler/CreateChannel.php",

        type: 'POST',
        data: formData,
        processData: false,// Image preview when user selects a file
        function previewImage(event) {
        const preview = document.getElementById("imagePreview");
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = "block";
    }


    document.getElementById("createChannelForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Collecting form data
        var channelName = document.getElementById("channel-name").value;
        var channelDescription = document.getElementById("channel-description").value;
        var channelImage = document.getElementById("channel-image").files[0];


        if (!channelName || !channelDescription) {
            alert("Please provide both the channel name and description.");
            return;
        }


        var formData = new FormData();
        formData.append("channel-name", channelName);
        formData.append("channel-description", channelDescription);

        // Append the image file if provided
        if (channelImage) {
            formData.append("channel-image", channelImage);
        }
        $.ajax({
            url: "../controler/CreateChannel.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Parse response if it's JSON
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        alert("Channel created successfully!");
                        // Optionally, redirect or reset the form
                        document.getElementById("createChannelForm").reset();
                        document.getElementById("imagePreview").style.display = "none"; // Hide image preview
                    } else {
                        alert("Error creating channel: " + jsonResponse.message);
                    }
                } catch (e) {
                    alert("An unexpected error occurred. Please try again.");
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred. Please try again.");
            }
        });
    });

    contentType: false,
        success: function(response) {
            alert("Channel created successfully!");

        }
        error: function(xhr, status, error) {
            alert("An error occurred. Please try again.");
        }
    });
});



    // Bootstrap form validation
    (function () {
    'use strict';
    window.addEventListener('load', function () {
    var form = document.getElementById('createChannelForm');
    form.addEventListener('submit', function (event) {
    if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
}
    form.classList.add('was-validated');
}, false);
}, false);
})();


    function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');

    if (file && file.type.startsWith('image/')) {
    const reader = new FileReader();
    reader.onload = function () {
    preview.style.display = 'block';
    preview.src = reader.result;
};
    reader.readAsDataURL(file);
} else {
    preview.style.display = 'none';
    preview.src = '';
}
}
