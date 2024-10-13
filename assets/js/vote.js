           document.addEventListener('DOMContentLoaded', function() {
                const voteButtons = document.querySelectorAll('.vote-button');

                voteButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();

                        const buildId = this.dataset.buildId;
                        const url = `/vote/build/${buildId}`;

                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                if (data.voteStatus === 'added') {
                                    button.textContent = 'Unlike';
                                } else {
                                    button.textContent = 'Like';
                                }
                            } else {
                                alert('An error occurred: ' + data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });
                });
            });

            