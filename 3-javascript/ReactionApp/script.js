// get new number
function randomNumberWEnding(max, min, type) {
	var number = Math.floor(Math.random() * (max - min + 1)) + min;
	if (Boolean(type)) {
		return("" + number + type + "");
	} else {
		return("" + number + "");
	}
}

// random two options
function randomTwoOptions(option1, option2) {
	var binary = Math.round(Math.random());
	if (binary == 1) {
		return(option1);
	} else {
		return(option2);
	}
}

// Start timer in miliseconds
var startSeconds = Date.now();

// Display new target shape
function newTarget() {

	// Get random numbers
	var size = randomNumberWEnding(200, 50,"px");
	var rColor = randomNumberWEnding(210, 0);
	var gColor = randomNumberWEnding(210, 0);
	var bColor = randomNumberWEnding(210, 0);
	var shape = randomTwoOptions("50%", "0%");
	var topLocation = randomNumberWEnding(500, 150,"px");
	var leftLocation = randomNumberWEnding(900, 100,"px");

	// set random in CSS
	document.getElementById("target").style.width = size;
	document.getElementById("target").style.height = size;
	document.getElementById("target").style.backgroundColor = "rgb(" + rColor + "," + gColor + ","+ bColor + ")";
	document.getElementById("target").style.borderRadius = shape;
	document.getElementById("target").style.top = topLocation;
	document.getElementById("target").style.left = leftLocation;
}

// Hide target 
function hideTarget() {
	document.getElementById("target").style.width = "0px";
	document.getElementById("target").style.height = "0px";
}

// new round
document.getElementById("target").onclick = function newRound() {

	// display score 
	endSeconds = Date.now();

	// hide target
	hideTarget()

	// display score 
	document.getElementById("yourTimeResulText").innerHTML = (endSeconds - startSeconds) / 1000;

	// delay 1 seconds, then set new random target
	setTimeout(newTarget, 50);

	// Clear timer in miliseconds
	startSeconds = Date.now();
}