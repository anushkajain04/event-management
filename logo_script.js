document.addEventListener("DOMContentLoaded", () => {

  function showInlineMessage(message, type = "error", duration = 2500) {
  const msgBox = document.getElementById("otpMessage");
  msgBox.textContent = message;
  msgBox.className = `form-message ${type}`;
  msgBox.style.display = "block";

  setTimeout(() => {
    msgBox.style.display = "none";
  }, duration);
}


  function showToast(message, type = "success", duration = 2500) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.className = `show ${type}`;

  setTimeout(() => {
    toast.className = "";
  }, duration);
}

  const container = document.getElementById("container");
  const registerBtn = document.getElementById("register");
  const loginBtn = document.getElementById("login");
  const signInBtn = document.getElementById("signInBtn");

signInBtn.onclick = () => {
  document.getElementById("loginForm").submit();
};



  registerBtn.onclick = () => container.classList.add("active");
  loginBtn.onclick = () => container.classList.remove("active");

  const forgotLink = document.getElementById("forgotLink");
  const loginForm = document.getElementById("loginForm");
  const otpForm = document.getElementById("otpForm");
  const backToLogin = document.getElementById("backToLogin");

  const sendOtpBtn = document.getElementById("sendOtpBtn");
  const verifyOtpBtn = document.getElementById("verifyOtpBtn");

  const otpEmail = document.getElementById("otpEmail");
  const otpInput = document.getElementById("otpInput");

  // Toggle forms
  forgotLink.onclick = (e) => {
    e.preventDefault();
    loginForm.style.display = "none";
    otpForm.style.display = "flex";
  };

  backToLogin.onclick = (e) => {
    e.preventDefault();
    otpForm.style.display = "none";
    loginForm.style.display = "flex";
  };

  // SEND OTP
sendOtpBtn.onclick = async () => {
  if (!otpEmail.value.trim()) {
    showInlineMessage("Please enter your email", "error");
    return;
  }

  const res = await fetch("send_otp.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=send&email=${encodeURIComponent(otpEmail.value)}`
  });

  const data = await res.json();

  if (data.status === "otp_sent") {
    showInlineMessage("OTP sent to your email", "success");
  } else if (data.status === "email_not_found") {
    showInlineMessage("Email not registered", "error");
  } else {
    showInlineMessage("Unable to send OTP", "error");
  }
};



  // VERIFY OTP
verifyOtpBtn.onclick = async () => {
  if (!otpInput.value.trim()) {
    showInlineMessage("Please enter OTP", "error");
    return;
  }

  const res = await fetch("send_otp.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=verify&otp=${encodeURIComponent(otpInput.value)}`
  });

  const data = await res.json();

  if (data.status === "success") {
    showInlineMessage("Verification successful", "success");

    setTimeout(() => {
      window.location.href = "host.php";
    }, 1400);

  } else if (data.status === "invalid") {
    showInlineMessage("Invalid OTP", "error");
  } else if (data.status === "expired") {
    showInlineMessage("OTP expired. Please resend.", "error");
  }
};


});








