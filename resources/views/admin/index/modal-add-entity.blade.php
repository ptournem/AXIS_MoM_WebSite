<!-- Modal entite -->
<div class="modal fade" id="ajouterEntite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
            <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Création entitées</h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td><label for="entity-type">Type :</label></td>
                        <td>
                            <select id="entity-type" class="entity-type" name="entity-type" size="1">
                                <option value="event">Evénement</option>
                                <option value="location">Lieu</option>
                                <option value="organisation">Organisation</option>
                                <option value="object">Objet</option>
                                <option value="person">Personne</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="entity-name">Nom : </label></td>
                        <td>
                            <input type="text" class="entity-name" id="entity-name" name="entity-name" required="true"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="entity-description">Description : </label></td>
                        <td>
                            <input type="text" class="entity-description" id="entity-description" name="entity-description" required="true"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="entity-image">Lien vers images : </label></td>
                        <td>
                            <input type="text" class="entity-image" id="entity-image" name="entity-image"/>
                        </td>
                    </tr>
		</table>
            </div>
            <div class="modal-footer">
		<button type="button" class="btn btn-default btn-close-add-entity" data-dismiss="modal">Fermer</button>
		<button type="submit" class="btn btn-primary btn-add-entity">Créer</button>
            </div>
	</div>
    </div>
</div>