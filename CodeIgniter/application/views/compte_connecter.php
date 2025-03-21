<?php echo validation_errors(); ?>

<?php echo form_open('compte/connecter'); ?>
	<center><label>Saisissez votre identifiants et mot de passe ci-dessous:</label></center><br>
	<center><input type="text" name="pseudo" /></center> <br>
	<center><input type="password" name="mdp" /></center> <br>
	<center><input type="submit" value="Connexion"/></center>
</form>
