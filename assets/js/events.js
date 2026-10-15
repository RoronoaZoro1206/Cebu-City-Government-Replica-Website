/**
 * Cebu City Government Portal - Events & Comments Controller
 */

document.addEventListener('DOMContentLoaded', () => {
    initReadMoreToggles();
    initCommentsHandler();
});

function initReadMoreToggles() {
    document.querySelectorAll('.btn-read-more-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const cardBody = this.closest('.event-card-body');
            const previewEl = cardBody.querySelector('.event-preview-text');
            const fullEl = cardBody.querySelector('.event-full-text');

            if (fullEl.style.display === 'none' || fullEl.style.display === '') {
                fullEl.style.display = 'block';
                previewEl.style.display = 'none';
                this.innerHTML = "Read Less <i class='bx bx-chevron-up'></i>";
            } else {
                fullEl.style.display = 'none';
                previewEl.style.display = 'block';
                this.innerHTML = "Read More <i class='bx bx-chevron-down'></i>";
            }
        });
    });
}

function initCommentsHandler() {
    const commentButtons = document.querySelectorAll('.btn-open-discussion');
    const commentsSection = document.getElementById('citizenDiscussionSection');
    const eventIdInput = document.getElementById('event_id');
    const parentIdInput = document.getElementById('parent_id');
    const discussionTitle = document.getElementById('discussionEventTitle');
    const commentList = document.getElementById('commentList');
    const commentForm = document.getElementById('commentForm');
    const replyNotice = document.getElementById('replyingToNotice');
    const replyUsernameEl = document.getElementById('replyUsernameText');
    const cancelReplyBtn = document.getElementById('btnCancelReply');

    // Click "Discuss this Announcement"
    commentButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const eventId = this.getAttribute('data-event-id');
            const eventTitle = this.getAttribute('data-event-title');

            if (eventIdInput) eventIdInput.value = eventId;
            if (parentIdInput) parentIdInput.value = '';
            if (discussionTitle) discussionTitle.textContent = eventTitle;

            cancelReply();
            loadComments(eventId);

            if (commentsSection) {
                commentsSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Load initial comments for first event if available
    if (eventIdInput && eventIdInput.value) {
        loadComments(eventIdInput.value);
    }

    function loadComments(eventId) {
        if (!commentList) return;
        commentList.innerHTML = `<div class="text-center py-4 text-muted"><i class='bx bx-loader-alt bx-spin fs-2'></i><p class="mt-2 mb-0">Loading comments...</p></div>`;

        fetch(`api/load_comments.php?event_id=${encodeURIComponent(eventId)}&_t=${Date.now()}`)
            .then(res => res.text())
            .then(html => {
                commentList.innerHTML = html;
                attachReplyListeners();
            })
            .catch(err => {
                commentList.innerHTML = `<div class="alert alert-danger">Error loading comments.</div>`;
            });
    }

    function attachReplyListeners() {
        if (!commentList) return;
        commentList.querySelectorAll('.reply-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const parentId = this.getAttribute('data-id');
                const targetUser = this.getAttribute('data-user');

                if (parentIdInput) parentIdInput.value = parentId;
                if (replyUsernameEl) replyUsernameEl.textContent = targetUser;
                if (replyNotice) replyNotice.style.display = 'block';

                const commentTextarea = document.getElementById('comment');
                if (commentTextarea) {
                    commentTextarea.focus();
                    commentTextarea.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    }

    if (cancelReplyBtn) {
        cancelReplyBtn.addEventListener('click', cancelReply);
    }

    function cancelReply() {
        if (parentIdInput) parentIdInput.value = '';
        if (replyNotice) replyNotice.style.display = 'none';
    }

    // Submit new comment via AJAX
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = commentForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = "<i class='bx bx-loader-alt bx-spin me-1'></i> Posting...";

            const formData = new FormData(commentForm);

            fetch('api/save_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const commentField = document.getElementById('comment');
                    if (commentField) commentField.value = '';
                    cancelReply();
                    loadComments(eventIdInput.value);
                } else {
                    alert('Error: ' + (data.error || 'Failed to post comment.'));
                }
            })
            .catch(err => {
                alert('An unexpected error occurred while posting your comment.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = "<i class='bx bx-send me-1'></i> Post Comment";
            });
        });
    }
}
