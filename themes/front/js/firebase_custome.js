
   var config = {
        apiKey: "AIzaSyDdtWa5VtbZUJCU68EaT4sAkFOY017RVYk",
        authDomain: "ava-rents-bea86.firebaseapp.com",
        databaseURL: "https://ava-rents-bea86.firebaseio.com",
        projectId: "ava-rents-bea86",
        storageBucket: "ava-rents-bea86.appspot.com",
        messagingSenderId: "918604010413"
      };
      firebase.initializeApp(config);


      // Get a reference to the Firebase Realtime Database
      var chatRef = firebase.database().ref();

      // Create an instance of Firechat


      firebase.auth().createUserWithEmailAndPassword(email, password).catch(function(error) {
      // Listen for authentication state changes
        
      });

    firebase.auth().onAuthStateChanged(function(user) {


              if (user) {

                     console.log(user);


                  $.ajax({
                        url:base_url+'user/chatIdUpdate',
                        type:'post',
                       data: {'chatId':user.uid}, 
                        success:function(resp){

                            firebase.auth().signOut().then(function() {}).catch(function(error) {});
                        
                        }
                  });
              } else {

                 firebase.auth().signOut().then(function() {}).catch(function(error) {});
                // If the user is not logged in, sign them in anonymously
                firebase.auth().signInAnonymously().catch(function(error) {
                  console.log("Error signing user in anonymously:", error);
                });
              }
            });


    