      
         var postData = {"firebaseId": firebaseId, "firebaseToken": "", "image": image,"name":name,"time": time};

                             newPostKey  = firebase.database().ref().child('users').child(firebaseId).key;
                      if(newPostKey ){
                             
                               var updates = {};
                              updates[newPostKey] = postData;
                              firebase.database().ref().child("users").update(updates);

                            }


   ////////////////////////////////////////////
   
               