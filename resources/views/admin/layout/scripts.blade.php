<script src="assets/js/toggle_bar.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

{{-- corrected modal code --}}
<script>
    // Clossing the modal on outside modal click
    document.addEventListener('click', function(event) {
        closeModalOutside(event, 'modal');
        closeModalOutside(event, 'updatemodal');
    });

    function closeModalOutside(event, modalId) {
        var modal = document.getElementById(modalId);

        if (event.target === modal) {
            modal.style.display = 'none';
            document.removeEventListener('click', closeModalOutside);
        }
    }
    // end clossing the modal outside modal click
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }


    //  end corrected modal code 



    // the routing function
    const currentRoute = window.location.href;
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        const linkHref = link.querySelector('a').href;
        if (currentRoute.includes(linkHref)) {
            link.classList.add('active-link');
        }
    });

    // The Global modal function script
    function openModal() {
        document.getElementById('modal').style.display = 'block';
        document.addEventListener('click', closeModalOutside);
    }
























    //The update modal start
    function openupdateModal(id, Event_Title, Event_Date, Event_Description, Img_Path) {
        document.getElementById('updatemodal').style.display = 'block';
        document.getElementById('event_id').value = id;
        document.getElementById('event_title_input').value = Event_Title;
        document.getElementById('event_date_input').value = Event_Date;
        document.getElementById('event_description_input').value = Event_Description;
        var imagePath = 'EventImages/' + Img_Path;
        document.getElementById('event_image').src = imagePath;


        var removeImageButton = document.querySelector('.remove_button');
        removeImageButton.addEventListener('click', function() {
            event.preventDefault();
            document.getElementById('event_image').src = '';
        });

        // Add event listener to the upload image button
        var uploadImageButton = document.querySelector('.update_button');
        uploadImageButton.addEventListener('click', function() {
            event.preventDefault();
            document.getElementById('file_input').click();
        });


        // Add event listener to file input change event
        var fileInput = document.getElementById('file_input');
        fileInput.addEventListener('change', function() {
            // Display the newly uploaded image
            var newImage = URL.createObjectURL(fileInput.files[0]);
            document.getElementById('event_image').src = newImage;
        });

        
        document.addEventListener('click', closeModalOutside);
    }

    //The update modal end

























    // {{-- Profile Modal --}}

    function openProfileModal() {
        document.getElementById('profile-modal').style.display = 'block';
        document.addEventListener('click', closeModalOutside);
    }

    function closeProfileModal() {
        document.getElementById('profile-modal').style.display = 'none';
        document.removeEventListener('click', closeModalOutside);
    }

    function closeProfileModalOutside(event) {
        var modal = document.getElementById('profile-modal');
        if (event.target === modal) {
            modal.style.display = 'none';
            document.removeEventListener('click', closeModalOutside);
        }
    }


    // {{-- User Modal --}}

    function openUserModal(username, email, phone) {
        document.getElementById('user-modal').style.display = 'block';

        userId = document.querySelector('.card .card-body .table .table-body tr td button').getAttribute(
            'data-user-id');

        var updateUrl = "{{ route('users.update', ':userId') }}";
        updateUrl = updateUrl.replace(':userId', userId);

        document.getElementById("user-modal").action = updateUrl;

        console.log('User ID:', userId);
        document.querySelector('#user-modal .modal-content .modal-head h4').textContent = username
        document.querySelector('#user-modal .modal-content .modal-body #user-email').value = email;

        document.addEventListener('click', closeModalOutside);
    }

    function closeUserModal() {
        document.getElementById('user-modal').style.display = 'none';
        document.removeEventListener('click', closeModalOutside);
    }

    function closeUserModalOutside(event) {
        var modal = document.getElementById('user-modal');
        if (event.target === modal) {
            modal.style.display = 'none';
            document.removeEventListener('click', closeModalOutside);
        }
    }



    // {{-- Ajax Deletions --}}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function deleteAnnouncement(id) {
        $.ajax({
            url: '/delete/' + id + '/announcement/',
            type: 'DELETE',
            success: function() {
                $('#announcement_' + id).remove();
                alert('Announcement deleted successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('An error occurred while deleting the announcement.');
            }
        });
    };
    //delete sermon notes
    function deleteSermonNotes(id) {
        $.ajax({
            url: '/delete/' + id + '/sermonnotes/',
            type: 'DELETE',
            success: function() {
                $('#sermonnotes_' + id).remove();
                alert('sermonnotes deleted successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('An error occurred while deleting the sermonnotes.');
            }
        });
    }
    //deleteEvent
    function deleteEvent(id) {
        $.ajax({
            url: '/delete/' + id + '/event/',
            type: 'DELETE',
            success: function() {
                $('#event_' + id).remove();
                alert('event deleted successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('An error occurred while deleting the event.');
            }
        });
    }


    // {{-- ------------- Scroll Carousel --------------- --}}

    document.addEventListener("DOMContentLoaded", function() {
        const scrollImages = document.querySelector(".scroll-images");
        const scrollLength = scrollImages.scrollWidth - scrollImages.clientWidth;
        const leftButton = document.querySelector(".left");
        const rightButton = document.querySelector(".right");

        function checkScroll() {
            const currentScroll = scrollImages.scrollLeft;
            if (currentScroll === 0) {
                leftButton.setAttribute("disabled", "true");
                rightButton.removeAttribute("disabled");
            } else if (currentScroll === scrollLength) {
                rightButton.setAttribute("disabled", "true");
                leftButton.removeAttribute("disabled");
            } else {
                leftButton.removeAttribute("disabled");
                rightButton.removeAttribute("disabled");
            }
        }

        scrollImages.addEventListener("scroll", checkScroll);
        window.addEventListener("resize", checkScroll);
        checkScroll();

        function leftScroll() {
            scrollImages.scrollBy({
                left: -200,
                behavior: "smooth"
            });
        }

        function rightScroll() {
            scrollImages.scrollBy({
                left: 200,
                behavior: "smooth"
            });
        }

        leftButton.addEventListener("click", leftScroll);
        rightButton.addEventListener("click", rightScroll);
    });
</script>

{{-- Display of image before upload --}}
<script>
    function displayImage() {
        var input = document.getElementById('eventupload');
        var imageDisplay = document.getElementById('image_display');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imageDisplay.innerHTML = '<img src="' + e.target.result +
                    '" alt="Uploaded Image" style="width: 100%; max-height: 300px;">';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
