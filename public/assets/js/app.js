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
    ajaxCall("GET", "/logout", undefined, undefined, callBackFunc);
  }

  function updateBlogPost(postId, newTitle, newContent) {
    var jsonData = { newTitle: newTitle, newContent: newContent };
    function callBackFunc() {
      console.log("OK");
    }
    ajaxCall("POST", "/api-update-blog-post/" + postId, "application/json", jsonData, callBackFunc);
  }

  function addComment(userId, postId, commentTxt) {
    var jsonData = { userId: userId, postId: postId, commentTxt: commentTxt };
    function callBackFunc() {
      // TODO: add comment immidiately
    }
    ajaxCall("POST", "/api-blog-post/" + postId + "/add-comment", "application/json", jsonData, callBackFunc);
  }

  function ajaxCall(method, path, contentType, jsonData, callBackFunc) {
    var xhttp = new XMLHttpRequest();
    xhttp.open(method, path);

    if(contentType) {
      xhttp.setRequestHeader('Content-Type', contentType);
    }
    xhttp.onreadystatechange = function() {
      callBackFunc(this);
    }

    if(jsonData) {
      var json = JSON.stringify(jsonData);
      xhttp.send(json);
    } else {
      xhttp.send();
    }
  }

  return {
    logIn: logIn,
    logOut: logOut,
    updateBlogPost: updateBlogPost,
    addComment: addComment
  }
}
