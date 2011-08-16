<h3>Expanded Profile Section</h3>

<p class="slore-help">Use this section to expand the information on your profile. Any fields that you leave blank will not show up on your profile.</p>

<table class="form-table">
	<tbody>
		
		<tr>
			<th>Company</th>
			<td><input type="text" name="expanded_profile[company]" value="<?=(isset($expanded_profile['company']) && $expanded_profile['company'] != '')?$expanded_profile['company']:''?>" class="regular-text"/></td>
		</tr>
		<tr>
			<th>Contact Email Address</th>
			<td><input type="text" name="expanded_profile[contact-email-address]" value="<?=(isset($expanded_profile['contact-email-address']) && $expanded_profile['contact-email-address'] != '')?$expanded_profile['contact-email-address']:''?>" class="regular-text"/></td>
		</tr>
		
		<tr>
			<th>Twitter</th>
			<td><input type="text" name="expanded_profile[twitter]" value="<?=(isset($expanded_profile['twitter']) && $expanded_profile['twitter'] != '')?$expanded_profile['twitter']:''?>" class="regular-text"/></td>
		</tr>
		<tr>
			<th>Facebook Profile</th>
			<td><input type="text" name="expanded_profile[facebook]" value="<?=(isset($expanded_profile['facebook']) && $expanded_profile['facebook'] != '')?$expanded_profile['facebook']:''?>" class="regular-text"/></td>
		</tr>
		<tr>
			<th>Phone</th>
			<td><input type="text" name="expanded_profile[phone]" value="<?=(isset($expanded_profile['phone']) && $expanded_profile['phone'] != '')?$expanded_profile['phone']:''?>" class="regular-text"/></td>
		</tr>
		<tr>
			<th>Cell</th>
			<td><input type="text" name="expanded_profile[cell]" value="<?=(isset($expanded_profile['cell']) && $expanded_profile['cell'] != '')?$expanded_profile['cell']:''?>" class="regular-text"/></td>
		</tr>
		<tr>
			<th>Fax</th>
			<td><input type="text" name="expanded_profile[fax]" value="<?=(isset($expanded_profile['fax']) && $expanded_profile['fax'] != '')?$expanded_profile['fax']:''?>" class="regular-text"/></td>
		</tr>
		
		<tr>
			<th>Address</th>
			<td>
				<textarea name="expanded_profile[address]" cols="20" rows="3"><?=(isset($expanded_profile['address']) && $expanded_profile['address'] != '')?$expanded_profile['address']:''?></textarea>
			</td>
		</tr>
		<? if(current_user_can('administrator')): ?>
		<tr>
			<th>User Type</th>
			<td>
				<ul>
					<li><input type="radio" name="user_profile_type" value="agent" <?=($user_type=='agent')?'checked="checked"':'';?>/> Real Estate Agent</li>
					<li><input type="radio" name="user_profile_type" value="mortgage" <?=($user_type=='mortgage')?'checked="checked"':'';?>/> Mortgage Broker</li>
					<li><input type="radio" name="user_profile_type" value="escrow" <?=($user_type=='escrow')?'checked="checked"':'';?>/> Escrow Officer</li>
				</ul>
			</td>
		</tr>
		<?endif;?>
	</tbody>
</table>