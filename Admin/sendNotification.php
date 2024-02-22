

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Management System</title>
    <link rel="stylesheet" href="index.css">
    
</head>

<style>
 
   
    .loading {
      
 --speed-of-animation: 0.9s;
 --gap: 6px;
 --first-color: #8B008B;
 --second-color: #00FFFF;
 --third-color: #8B008B;
 --fourth-color: #00FFFF;
 --fifth-color: #8B008B;
 display: flex;
 justify-content: center;
 align-items: center;
 width: 100px;
 gap: 6px;
 height: 100px;
 position: relative;
 left: 500px;
}

.loading span {
 width: 4px;
 height: 50px;
 background: var(--first-color);
 animation: scale var(--speed-of-animation) ease-in-out infinite;
}

.loading span:nth-child(2) {
 background: var(--second-color);
 animation-delay: -0.8s;
}

.loading span:nth-child(3) {
 background: var(--third-color);
 animation-delay: -0.7s;
}

.loading span:nth-child(4) {
 background: var(--fourth-color);
 animation-delay: -0.6s;
}

.loading span:nth-child(5) {
 background: var(--fifth-color);
 animation-delay: -0.5s;
}

@keyframes scale {
 0%, 40%, 100% {
  transform: scaleY(0.05);
 }

 20% {
  transform: scaleY(1);
 }
}
.input-container {
  display: flex;
  align-items: center;
  background-color: #0F172A;
  padding: 10px 15px;
  gap: 5px;
  border-radius: 20px;
  width: 400px;
  position: relative;
  left: 350px;
  top: 90px;
}
.input-container input{
    width: 400px;
    border-radius: 6px;
   
}

.input-container .bash-text {
  font-size: .8rem;
  color: white;
}

.input-container .bash-text .user {
  color: #E879F9;
}

.input-container .bash-text .vm {
  color: #2DD4BF;
}

.input-container .bash-text .char {
  color: #A78BFA;
}

.input-container input[type=text].input {
  background-color: transparent;
  border: none;
  outline: none;
  color: white;
}
.cssbuttons-io {
  position: relative;
  font-family: inherit;
  font-weight: 500;
  font-size: 18px;
  letter-spacing: 0.05em;
  border-radius: 0.8em;
  border: 1px solid purple;
  background: purple;
  color: ghostwhite;
  overflow: hidden;
  top: 130px;
  left: 500px;
}

.cssbuttons-io svg {
  width: 1.2em;
  height: 1.2em;
  margin-right: 0.5em;
}

.cssbuttons-io span {
  position: relative;
  z-index: 10;
  transition: color 0.4s;
  display: inline-flex;
  align-items: center;
  padding: 0.8em 1.2em 0.8em 1.05em;
}

.cssbuttons-io::before,
.cssbuttons-io::after {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
}

.cssbuttons-io::before {
  content: "";
  background: #000;
  width: 120%;
  left: -10%;
  transform: skew(30deg);
  transition: transform 0.4s cubic-bezier(0.3, 1, 0.8, 1);
}

.cssbuttons-io:hover::before {
  transform: translate3d(100%, 0, 0);
}

.cssbuttons-io:active {
  transform: scale(0.95);
}
h6{
    color: white;
    position: relative;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: 100;
    left: 350px;
    color: gray;
}

</style>
   
<body>
<div class="loading">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
</div>
<h6>This page is intended for administrators only. Unauthorized access is prohibited.</h6>
 <!-- Form to send notifications -->
 <form action="../Student/notifications.php" method="post">
        <div class="input-container">
  <p class="bash-text">
    <span class="user">user</span><span class="vm">@khaled</span>:<span class="char">~</span>$
  </p>
  <input class="input" name="notifications" placeholder="write notifications" type="text">
</div>
    </button>
    <button name="send" class="cssbuttons-io">
  <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0z"></path><path fill="currentColor" d="M24 12l-5.657 5.657-1.414-1.414L21.172 12l-4.243-4.243 1.414-1.414L24 12zM2.828 12l4.243 4.243-1.414 1.414L0 12l5.657-5.657L7.07 7.757 2.828 12zm6.96 9H7.66l6.552-18h2.128L9.788 21z"></path></svg>Send</span>
</button>
    </form>
   
</body>
</html>
