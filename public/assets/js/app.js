function App() {

  function logIn() {
    var email = document.getElementById("email-login").value;
    var password = document.getElementById("pass-login").value;
    var jsonData = { email: email, password: password };

    function callBackFunc(scopedThis) {
      if (scopedThis.readyState == 4 && scopedThis.status == 200) {
        location.reload();
      } else if (scopedThis.readyState == 4 && scopedThis.status == 401 && scopedThis.statusText == "Unauthorized") {
        document.getElementById("user-not-found").style.visibility = "visible";
      }
    }

    ajaxCall("POST", "/login", "application/json", jsonData, callBackFunc);

  }

  function logOut() {
    function callBackFunc() {
      location.reload();
    }
    ajaxCall("GET", "/logout", null, null, null, callBackFunc);
  }

  function updateBlogPost(postId, newTitle, newContent) {
    var jsonData = { newTitle: newTitle, newContent: newContent };
    function callBackFunc() {
      showNotification("Post successfully edited!");
    }
    ajaxCall("POST", "/api-update-blog-post/" + postId, "application/json", jsonData, "json", callBackFunc);
  }

  function addComment(userId, postId, commentTxt, hasRoleAdmin, isOwner) {
    var jsonData = { userId: userId, postId: postId, commentTxt: commentTxt };
    function callBackFunc(scopedThis) {
      if (scopedThis.readyState == 4 && scopedThis.status == 200) {
        document.getElementById("comment-txt").value = "";
        var jsonResponseObj = JSON.parse(scopedThis.response);

        var commentContinerInnerHTML = `<input type="hidden" value="` + jsonResponseObj.commentId + `">
                                        <div class="comment-column avatar">
                                          <img src="/assets/img/no-avatar.png">
                                        </div>
                                        <div class="comment-column">
                                          <div class="comment-row">
                                            <h5>
                                              ` + jsonResponseObj.fullName + `
                                              <small>` + jsonResponseObj.commentDateTime + (hasRoleAdmin ? ` <span class="comment-hidden"></span>` : ``) + `</small>` +
                                              (hasRoleAdmin || isOwner ? `<div class="comment-menu">` : ``) +
                                              (hasRoleAdmin ? `<button class="comment-hide-btn" data-comment-id="` + jsonResponseObj.commentId + `"></button>` : ``) +
                                              (hasRoleAdmin || isOwner ? ` <button class="comment-delete-btn" data-comment-id="` + jsonResponseObj.commentId + `"></button>` : ``) +
                                              (hasRoleAdmin || isOwner ? `</div>` : ``) +
                                            `</h5>
                                          </div>
                                          <div class="comment-row">` + jsonResponseObj.commentTxt + `</div>
                                        </div>`;

        var $commentsContainerEl = document.getElementById("blog-post-comments");
        $commentDomEl = document.createElement('div');
        $commentDomEl.classList.add("comment-container");
        $commentDomEl.innerHTML = commentContinerInnerHTML;

        if(hasRoleAdmin) {
          var $hideShowCommentBtn = $commentDomEl.getElementsByClassName('comment-hide-btn')[0];
          $hideShowCommentBtn.onclick = function() {
            var commentId = this.getAttribute('data-comment-id');
            hideShowComment(this, commentId);
          }
        }

        if(hasRoleAdmin || isOwner) {
          var $deleteCommentBtn = $commentDomEl.getElementsByClassName('comment-delete-btn')[0];
          $deleteCommentBtn.onclick = function() {
            var commentId = this.getAttribute('data-comment-id');
            deleteComment(this, commentId);
          }
        }

        $commentsContainerEl.appendChild($commentDomEl);
      }
    }
    ajaxCall("POST", "/api-blog-post/" + postId + "/add-comment", "application/json", jsonData, "json", callBackFunc);
  }

  function hideShowComment(btn, commentId) {
    function callBackFunc() {
      var $spanHiddenShownEl = btn.parentElement.parentElement.getElementsByClassName("comment-hidden")[0];
      if($spanHiddenShownEl.innerHTML == "(hidden)") {
        $spanHiddenShownEl.innerHTML = "";
      } else {
        $spanHiddenShownEl.innerHTML = "(hidden)";
      }
    }

    ajaxCall("POST", "/api-blog-post/hide-show-comment/" + commentId, "application/json", null, null, callBackFunc);
  }

  function deleteComment(btn, commentId) {

    function callBackFunc() {
      var $commentEl = btn.parentElement.parentElement.parentElement.parentElement.parentElement;
      $commentEl.remove();
    }

    var isConfirmed = confirm("Are you sure you want to delete this comment?");
    if (isConfirmed) {
      ajaxCall("POST", "/api-blog-post/delete-comment/" + commentId, "application/json", null, null, callBackFunc);
    }
  }

  function addPost(userId, formData) {
    function callBackFunc() {
      showNotification("Post successfully added!");
      document.getElementById("post-title").value = "";
      document.getElementById("post-content").value = "";
      document.getElementById("file-upload").value = ""
      document.getElementById("selected-file-name").innerHTML = "";
    }

    ajaxCall("POST", "/api-post-add/" + userId, "multipart/form-data", formData, "form", callBackFunc);
  }

  return {
    logIn: logIn,
    logOut: logOut,
    updateBlogPost: updateBlogPost,
    addComment: addComment,
    hideShowComment: hideShowComment,
    deleteComment: deleteComment,
    addPost: addPost
  }

  function ajaxCall(method, path, contentType, data, dataType, callBackFunc) {
    var xhttp = new XMLHttpRequest();
    xhttp.open(method, path);

    if(contentType != "multipart/form-data") {
      xhttp.setRequestHeader('Content-Type', contentType);
    }
    xhttp.onreadystatechange = function() {
      callBackFunc(this);
    }

    if(data) {
      if(dataType == "json") {
        var json = JSON.stringify(jsonData);
        xhttp.send(json);
      } else if(dataType == "form") {
        xhttp.send(data);
      }
    } else {
      xhttp.send();
    }
  }

  function showNotification(notificationText) {
    var $notification = document.getElementById("notification");
    $notification.innerHTML = notificationText;
    $notification.classList.remove("is-hidden");
    setTimeout(function() {
      $notification.classList.add("is-hidden");
    }, 3000);
  }
}
