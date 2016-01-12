<?php

namespace App\Http\Controllers;


class InformationController extends Controller {

    public function Infos() {
        $comments = array(array('Robin', 'très belle oeuvre'), 
            array('Riad', 'wallah elle chill cette tablette'), 
            array('Corentin', 'moi aime pas trop')); 
        
        $infos = array(array('Artiste', 'Jacques Louis David'), 
            array('Période', 'Néo-Classicisme'), 
            array('Support', 'Peinture à l\'huile'),
            array('Lieu', 'Musée du Louvre')); 
        
        $itemName = 'Le sacre de Napoléon';
        
        $data = array(
            'comments'  => $comments,
            'infos'   => $infos,
            'itemName' => $itemName
        );
	return view('informations')->with($data);
    }   
}
