
function togglePassword() {
  const input = document.getElementById("password");
  const icon = document.getElementById("toggleIcon");
  const isPassword = input.type === "password";
  input.type = isPassword ? "text" : "password";

  icon.classList.toggle("bi-eye");
  icon.classList.toggle("bi-eye-slash");
}