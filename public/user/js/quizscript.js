function shuffle() {
    var container = document.getElementById("container");
    var elementsArray = Array.prototype.slice.call(container.getElementsByClassName('shuffleMe'));
      elementsArray.forEach(function(element){
      container.removeChild(element);
    })
    shuffleArray(elementsArray);
    elementsArray.forEach(function(element){
    container.appendChild(element);
  })
  }
  
  function shuffleArray(array) {
      for (var i = array.length - 1; i > 0; i--) {
          var j = Math.floor(Math.random() * (i + 1));
          var temp = array[i];
          array[i] = array[j];
          array[j] = temp;
      }
      return array;
  }
 
   

  
  function quizswitch() {
    let counter = 0;
    const questions = document.querySelectorAll('.quiz-question');

    const prev = document.getElementById('prev');
    const plus = document.getElementById('plus');

    prev.addEventListener('click', function() {
        if (counter > 0) {
            questions[counter].style.display = 'none';
            counter--;
            questions[counter].style.display = 'block';
        }
    });

    plus.addEventListener('click', function() {
        if (counter < questions.length - 1) {
            questions[counter].style.display = 'none';
            counter++;
            questions[counter].style.display = 'block';
        }
    });
}