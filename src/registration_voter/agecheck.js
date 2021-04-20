/* This script checks if the voter has attained the minimum age required to vote. */

// The minimum age required to vote.
var min_age = 18;

// Calculate age when given the date of birth.
function calculate_age(dob) {
    var diff1 = Date.now() - dob.getTime();
    var age_dt = new Date(diff1);
    return Math.abs(age_dt.getUTCFullYear() - 1970);
}

// Verify that the candidate has attained the minimum voting age.
function validateForm() {
    var d = new Date(document.getElementById("cdob").value);
    var c = calculate_age(d);
    if (c < min_age) {
        alert("You are only " + c + " years old. You should be at least " + min_age + " years old to be eligible to vote");
        return false;
    }
}