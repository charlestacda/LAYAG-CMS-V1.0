<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();


include('includes/header.php');
?>
<style>
    .button-container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        overflow-x: auto;
    }

    .large-button {
        position: relative;
        /* Add relative positioning */
        width: 150px;
        height: 280px;
        margin: 10px;
        font-size: 18px;
        text-align: center;
        background-color: #b84444;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .large-button.add-button {
        background-color: #b84444;
    }

    .dots-button {
        position: absolute;
        /* Position the dots button absolutely */
        top: 10px;
        /* Adjust the top position as needed */
        right: 10px;
        /* Adjust the right position as needed */
        cursor: pointer;
        color: #ffffff;
        font-size: 24px;
        z-index: 1;
        /* Ensure it's above the profile button */
    }

    .center-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    /* Add this CSS to your existing styles */
    .context-menu {
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 0px 5px 0px #ccc;
        z-index: 999;
        padding: 5px 0;
    }

    .menu-item {
        padding: 8px 16px;
        cursor: pointer;
    }

    .menu-item:hover {
        background-color: #f5f5f5;
    }
</style>
<div class="center-content">
    <h1 class="text-center">Choose Profile</h1>
    

    <div class="button-container">
        <?php
        function displayProfile($connect)
        {
            $query = "SELECT * FROM profiles WHERE archived = 0";
            $result = mysqli_query($connect, $query);

            if (!$result) {
                die("Database query failed: " . mysqli_error($connect));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='large-button' data-profile-id='" . $row['profile_id'] . "' data-profile-name='" . $row['profile_name'] . "' data-profile-desc='" . $row['profile_desc'] . "'>";
                echo "<div class='dots-button' data-profile-id='" . $row['profile_id'] . "'>&#8226;&#8226;&#8226;</div>";
                echo "<h2>" . $row['profile_name'] . "</h2>";
                echo "<p>" . $row['profile_desc'] . "</p>";
                echo "</div>";
            }
        }

        if (!isset($_SESSION['user_id'])) {
            echo "<p class='text-center'>Please log in to access this page.</p>";
        } else {
            displayProfile($connect);

            echo "<button class='large-button add-button' data-mdb-toggle='modal' data-mdb-target='#addProfileModal'>";
            echo "<span class='plus-sign'>&#43;</span>";
            echo "</button>";
        }
        ?>
    </div>
</div>

<div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProfileModalLabel">Add Profile</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="addProfileForm">
                    <div class="mb-3">
                        <label for="profileName" class="form-label">Profile Name</label>
                        <input type="text" class="form-control" id="profileName" name="profile_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="profileDesc" class="form-label">Profile Description</label>
                        <input type="text" class="form-control" id="profileDesc" name="profile_desc">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
                <button type="submit" form="addProfileForm" class="btn btn-danger">Add Profile</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="editProfileForm">
                    <input type="hidden" id="editProfileId" name="profile_id" value="">
                    <div class="mb-3">
                        <label for="editProfileName" class="form-label">Profile Name</label>
                        <input type="text" class="form-control" id="editProfileName" name="profile_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProfileDesc" class="form-label">Profile Description</label>
                        <input type="text" class="form-control" id="editProfileDesc" name="profile_desc">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
                <button type="submit" form="editProfileForm" class="btn btn-danger">Update Profile</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-labelledby="deleteProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProfileModalLabel">Archive Profile</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deleteProfileName"></p>
                <p>Are you sure you want to archive this profile?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Archive Profile</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttonContainer = document.querySelector(".button-container");

    function handleProfileButtonClick(event) {
    const targetButton = event.target.closest('.large-button');
    if (!targetButton) {
        return; // If no .large-button was clicked, exit
    }

    const profileId = targetButton.getAttribute('data-profile-id');
    const profileName = targetButton.getAttribute('data-profile-name');


    if (event.target.classList.contains('dots-button')) {
        // Create a new context menu element
        const contextMenu = document.createElement('div');
        contextMenu.classList.add('context-menu');

        // Add your options to the context menu
        const editOption = document.createElement('div');
        editOption.classList.add('menu-item');
        editOption.textContent = 'Edit Profile';
        contextMenu.appendChild(editOption);

        const deleteOption = document.createElement('div');
        deleteOption.classList.add('menu-item');
        deleteOption.textContent = 'Archive Profile';
        contextMenu.appendChild(deleteOption);

        // Position the context menu relative to the 3-dot button
        contextMenu.style.left = event.clientX + 'px';
        contextMenu.style.top = event.clientY + 'px';

        // Add the context menu to the document
        document.body.appendChild(contextMenu);

        // Close the context menu when clicking outside of it
        document.addEventListener('click', function (closeEvent) {
            if (!closeEvent.target.classList.contains('dots-button')) {
                contextMenu.remove();
            }
        });

        // Handle "Edit Profile" option click
        editOption.addEventListener('click', function () {
            const profileId = targetButton.getAttribute('data-profile-id');
            const profileName = targetButton.getAttribute('data-profile-name');
            const profileDesc = targetButton.getAttribute('data-profile-desc');

            // Populate the edit modal with the current profile information
            document.getElementById('editProfileId').value = profileId;
            document.getElementById('editProfileName').value = profileName;
            document.getElementById('editProfileDesc').value = profileDesc;

            // Open the edit modal
            $('#editProfileModal').modal('show');
        });

        // Handle "Delete Profile" option click
        deleteOption.addEventListener('click', function (e) {
            e.stopPropagation(); // Prevent the click event from propagating to the body click listener
            const profileId = targetButton.getAttribute('data-profile-id');
            const profileName = targetButton.getAttribute('data-profile-name');

            // Show the delete confirmation modal with profile name
            showDeleteConfirmationModal(profileId, profileName);
        });
    }else if (profileId !== null) {
        // Use URLSearchParams to construct the URL with both profile_id and profile_name
        const params = new URLSearchParams();
        params.set('profile_id', profileId);
        params.set('profile_name', profileName);

        window.location.href = `dashboard.php?${params.toString()}`;
    }
}



    buttonContainer.addEventListener("click", handleProfileButtonClick);

    // Define the showDeleteConfirmationModal function here
    function showDeleteConfirmationModal(profileId, profileName) {
        const deleteProfileNameElement = document.getElementById("deleteProfileName");
        const confirmDeleteButton = document.getElementById("confirmDeleteButton");

        // Set the profile name in the modal
        deleteProfileNameElement.textContent = `Archive profile: ${profileName}`;

        // Show the delete confirmation modal
        $('#deleteProfileModal').modal('show');

        // Handle "Delete Profile" button click within the modal
        confirmDeleteButton.addEventListener("click", function () {
            // Disable the modal UI during the delete
            const modal = document.getElementById('deleteProfileModal');
            modal.querySelectorAll('button').forEach((element) => {
                element.disabled = true;
            });

            // Send an AJAX request to delete the profile
            $.ajax({
                type: "POST",
                url: "profile_delete.php", // Replace with the actual URL for deleting profiles
                data: {
                    profile_id: profileId
                },
                success: function (response) {
                    if (response === "success") {
                        // Profile deleted successfully
                        $('#deleteProfileModal').modal('hide');
                        // Reload the page to reflect the updated list of profiles
                        location.reload();
                    } else {
                        // Handle errors, e.g., display an error message
                        alert("Error deleting profile");
                    }
                },
                complete: function () {
                    // Re-enable the modal UI and remove the loading indicator
                    modal.querySelectorAll('button').forEach((element) => {
                        element.disabled = false;
                    });
                    loadingIndicator.remove();
                }
            });
        });
    }

    // Handle "Update Profile" form submission
    document.getElementById("editProfileForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Disable the modal UI during the update
        const modal = document.getElementById('editProfileModal');
        modal.querySelectorAll('input, button').forEach((element) => {
            element.disabled = true;
        });

        // Show a loading indicator
        const loadingIndicator = document.createElement('div');
        loadingIndicator.textContent = 'Updating...'; // You can use a loading spinner or an icon here
        modal.appendChild(loadingIndicator);

        const profileId = document.getElementById("editProfileId").value;
        const profileName = document.getElementById("editProfileName").value;
        const profileDesc = document.getElementById("editProfileDesc").value;

        // Send an AJAX request to update the profile
        $.ajax({
            type: "POST",
            url: "profile_edit.php", // Replace with the actual URL for updating profiles
            data: {
                profile_id: profileId,
                profile_name: profileName,
                profile_desc: profileDesc
            },
            success: function (response) {
                if (response === "success") {
                    // Profile updated successfully
                    $('#editProfileModal').modal('hide');
                    // Reload the page to reflect the updated list of profiles
                    location.reload();
                } else {
                    // Handle errors, e.g., display an error message
                    alert("Error updating profile");
                }
            },
            complete: function () {
                // Re-enable the modal UI and remove the loading indicator
                modal.querySelectorAll('input, button').forEach((element) => {
                    element.disabled = false;
                });
                loadingIndicator.remove();
            }
        });
    });

    // Handle "Add Profile" form submission
    document.getElementById("addProfileForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Disable the modal UI during the add
        const modal = document.getElementById('addProfileModal');
        modal.querySelectorAll('input, button').forEach((element) => {
            element.disabled = true;
        });

        // Show a loading indicator
        const loadingIndicator = document.createElement('div');
        loadingIndicator.textContent = 'Adding...'; // You can use a loading spinner or an icon here
        modal.appendChild(loadingIndicator);

        const profileName = document.getElementById("profileName").value;
        const profileDesc = document.getElementById("profileDesc").value;

        // Send an AJAX request to add the profile
        $.ajax({
            type: "POST",
            url: "profile_add.php", // Replace with the actual URL for adding profiles
            data: {
                profile_name: profileName,
                profile_desc: profileDesc
            },
            success: function (response) {
                if (response === "success") {
                    // Profile added successfully
                    $('#addProfileModal').modal('hide');
                    // Reload the page to reflect the updated list of profiles
                    location.reload();
                } else {
                    // Handle errors, e.g., display an error message
                    alert("Error adding profile");
                }
            },
            complete: function () {
                // Re-enable the modal UI and remove the loading indicator
                modal.querySelectorAll('input, button').forEach((element) => {
                    element.disabled = false;
                });
                loadingIndicator.remove();
            }
        });
    });
});

</script>


<?php include('includes/footer.php'); ?>
