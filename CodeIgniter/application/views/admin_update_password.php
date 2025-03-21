	<?php echo validation_errors(); ?>

	<?php echo form_open('compte/modifier'); ?> <!-- Formulaire ou les regles ont été définies-->
		<center><label>Saisissez le mot de passe souhaité ci-dessous:</label></center><br>
		<center><input type="password" name="new_mdp" /></center> <br>
		<center><input type="password" name="confirm_new_mdp" /></center> <br>
		<center><input type="submit" value="Modifier"/></center>
	</form>
	
	
	<br/>
	<?php 
	if ($this->session->userdata('statut') == 'Admin') 
	{
?>		<center> <button type="button"> <a href = "<?php echo $this->config->base_url();?>index.php/programmation/lister_admin"> Annuler </a> </center>
<?php

	}
	else if ($this->session->userdata('statut') == 'Invite')
	{
		?>		<center> <button type="button"> <a href = "<?php echo $this->config->base_url();?>index.php/PresentationInvites/getInfos"> Annuler </a> </center>
		<?php		
		
	}
	else
	{
		redirect(base_url()."index.php/compte/connecter");
	}
	?>
	