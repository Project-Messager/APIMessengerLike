# APIMessengerLike
API de l'application mobile messenger like

### Routes 

Documentation pour la classe `ApiMessageController` :

1. **Fonction pour ajouter un message :**
   1. Méthode POST : http://localhost/ApiMessage/AddMessage
   2. Données en entrées : body, userSender, userReceiver
   3. Données en sortie : JSON contenant le résultat de l'ajout du message

2. **Fonction pour récupérer tous les messages par ID d'utilisateur émetteur et récepteur :**
   1. Méthode GET : http://localhost/ApiMessage/getAllById
   2. Données en entrées : idUserSender, idUserReceiver
   3. Données en sortie : JSON contenant des objets de tous les champs de tous les messages

3. **Fonction pour récupérer le dernier message par ID d'utilisateur émetteur et récepteur :**
   1. Méthode GET : http://localhost/ApiMessage/getLastMessageById
   2. Données en entrées : idUserSender, idUserReceiver
   3. Données en sortie : JSON contenant les champs du dernier message

4. **Fonction pour récupérer toutes les conversations d'un utilisateur émetteur :**
   1. Méthode GET : http://localhost/ApiMessage/getAllConversation
   2. Données en entrées : idUserSender
   3. Données en sortie : JSON contenant des objets de tous les champs de tous les messages, avec les derniers messages de chaque conversation

5. **Fonction pour mettre à jour un message :**
   1. Méthode POST : http://localhost/ApiMessage/UpdateMessage
   2. Données en entrées : id, body
   3. Données en sortie : JSON contenant le résultat de la mise à jour du message

6. **Fonction pour supprimer un message :**
   1. Méthode DELETE : http://localhost/ApiMessage/DeleteMessage
   2. Données en entrées : id
   3. Données en sortie : JSON contenant le résultat de la suppression du message

Documentation pour la classe `ApiUserController` :

1. **Fonction pour ajouter un utilisateur :**
   1. Méthode POST : http://localhost/ApiUser/AddUser
   2. Données en entrées : name, password, mail, firstName, lastName
   3. Données en sortie : JSON contenant le résultat de l'ajout de l'utilisateur

2. **Fonction pour récupérer tous les utilisateurs :**
   1. Méthode GET : http://localhost/ApiUser/getAll
   2. Données en entrées : Aucune (la vérification du token est effectuée côté serveur)
   3. Données en sortie : JSON contenant des objets de tous les champs de tous les utilisateurs

3. **Fonction pour récupérer un utilisateur par ID :**
   1. Méthode GET : http://localhost/ApiUser/getById/{id}
   2. Données en entrées : id de l'utilisateur
   3. Données en sortie : JSON contenant les champs de l'utilisateur

4. **Fonction pour l'authentification de l'utilisateur :**
   1. Méthode POST : http://localhost/ApiUser/login
   2. Données en entrées : email, password
   3. Données en sortie : JSON contenant l'id de l'utilisateur et le token en cas de succès, sinon un message d'erreur
