<?php
/**
 * PH2M_PhLaposteGenerateLabel
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   LaposteGenerateLabel
 * @copyright  Copyright (c) 2017 PH2M SARL
 * @author     PH2M | Bastien Lamamy (bastienlm)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class PH2M_PhLaposteGenerateLabel_Helper_Error extends Mage_Core_Helper_Abstract {

    protected $_errorMessage = [];

    public function __construct() {
        $this->_initErrorMessage();
    }

    /**
     * @param $code
     * @return bool|mixed
     */
    public function getErrorMessageByCode($code)
    {
        if(array_key_exists($code, $this->_errorMessage)) {
            return $this->_errorMessage[$code];
        }
        return false;
    }


    protected function _initErrorMessage()
    {
        $this->_errorMessage = [
            "30000" => "Identifiant ou mot de passe incorrect",
            "30002" => "La date de dépôt est antérieure à la date courante",
            "30007" => "Client inactif. Veuillez prendre contact avec votre interlocuteur commercial.",
            "30008" => "Service non autorisé pour cet identifiant. Veuillez prendre contact avec votre interlocuteur commercial afin de réinitialiser votre compte client",
            "30009" => "Service non autorisé pour ce produit. Veuillez prendre contact avec votre interlocuteur commercial",
            "30010" => "La date n'a pas été transmise",
            "30014" => "Le code produit n'a pas été transmis",
            "30015" => "Le code produit est incorrect",
            "30017" => "La valeur du champ contre remboursement est incorrecte",
            "30018" => "Le nom commercial n'a pas été transmis",
            "30020" => "Le montant total des frais de transport n'a pas été transmis",
            "30022" => "La langue de l'expéditeur est incorrecte",
            "30023" => "La langue du destinataire est incorrecte",
            "30025" => "Le type d'impression n'a pas été transmis",
            "30026" => "Le type d'impression est incorrect",
            "30065" => "Le nom de l'expéditeur n'a pas été transmis",
            "30043" => "Le prénom de l'expéditeur n'a pas été transmis",
            "30045" => "L'email de l'expéditeur n'a pas été transmis",
            "30046" => "L'email de l'expéditeur est incorrect",
            "30047" => "Le téléphone de l'expéditeur est incorrect",
            "30085" => "Le numéro de téléphone fixe de l'expéditeur est incorrect",
            "30089" => "La raison social du destinataire n'a pas été transmise",
            "30090" => "La taille du paramètre AddresseeParcelRef est nulle ou supérieure",
            "30100" => "Le numéro / libellé de voie de l'expéditeur n'a pas été transmis",
            "30102" => "Le code pays de l'expéditeur n'a pas été transmis",
            "30103" => "Le code pays de l'expéditeur est incorrect",
            "30104" => "La ville de l'expéditeur n'a pas été transmise",
            "30106" => "Le code postal de l'expéditeur n'a pas été transmis",
            "30107" => "Le code postal de l'expéditeur est incorrect",
            "30108" => "Le code postal de l'expéditeur ne correspond pas au pays",
            "30109" => "Le code pays ou le code postal de l'expéditeur est incorrect pour le code produit fourni",
            "30200" => "Le nom du destinataire n'a pas été transmis",
            "30202" => "Le prénom du destinataire n'a pas été transmis",
            "30204" => "Le numéro / libellé de voie du destinataire n'a pas été transmis",
            "30206" => "Le code pays du destinataire n'a pas été transmis",
            "30207" => "Le code pays du destinataire est incorrect",
            "30208" => "La ville du destinataire n'a pas été transmise",
            "30210" => "Le code postal du destinataire n'a pas été transmis",
            "30211" => "Le code postal du destinataire est incorrect",
            "30212" => "Le code postal du destinataire ne correspond pas au pays",
            "30213" => "Le code pays ou le code postal du destinataire est incorrect pour le code produit fourni",
            "30220" => "Le numéro de portable du destinataire n'a pas été transmis",
            "30221" => "Le numéro de portable du destinataire est incorrect",
            "30222" => "Le courriel du destinataire n'a pas été transmis",
            "30223" => "Le courriel du destinataire est incorrect",
            "30300" => "Le poids du colis n'a pas été transmis",
            "30301" => "Le poids du colis est incorrect",
            "30303" => "La valeur du champ hors gabarit est incorrecte",
            "30306" => "L'option recommandation est incorrecte",
            "30309" => "L'option valeur assurée est incorrecte",
            "30310" => "Le niveau de recommandation n'a pas été transmis",
            "30311" => "Le niveau de recommandation est incorrect",
            "30312" => "Les options ne permettent pas d’effectuer un étiquetage",
            "30313" => "Le synonyme du code produit est vide",
            "30316" => "Le code pays ne permet pas d’effectuer un étiquetage",
            "30317" => "Les options ne permettent pas d’effectuer un étiquetage",
            "30321" => "Le numéro de colis est incorrect",
            "30323" => "Le type de choix retour n'a pas été transmis",
            "30324" => "Le type de choix retour est incorrect",
            "30325" => "L'option avis de réception est incorrecte",
            "30326" => "L'option Franc de Taxes et de Droits est incorrecte",
            "30327" => "Le numéro de colis n'a pas été transmis",
            "30400" => "Le code point de retrait n'a pas été transmis",
            "30401" => "Le code point de retrait est incorrect",
            "30402" => "L’adresse point de retrait n'a pas été transmis",
            "30403" => "Le code ou l’adresse point de retrait n'a pas été transmis",
            "30500" => "Le contenu du colis n’a pas été transmis",
            "30503" => "La catégorie de l’envoi n’a pas été transmise",
            "30504" => "La catégorie de l’envoi est incorrecte",
            "30505" => "Les articles contenus n’ont pas été transmis",
            "30506" => "Le nombre d’articles est supérieur au maximum",
            "30507" => "Le poids total des articles est supérieur au poids du colis",
            "30510" => "La description d'un article n'a pas été transmise",
            "30511" => "La description d'un article est incorrecte",
            "30512" => "La quantité d'un article n'a pas été transmise",
            "30513" => "La quantité d'un article est incorrecte",
            "30514" => "Le poids d'un article n'a pas été transmis  ",
            "30515" => "Le poids d'un article est incorrect",
            "30516" => "La valeur d'un article n'a pas été transmise",
            "30517" => "La valeur d'un article est incorrecte",
            "30518" => "Le numéro tarifaire d'un article n'a pas été transmis",
            "30519" => "Le numéro tarifaire d'un article est incorrect",
            "30520" => "Le pays d'origine d'un article n'a pas été transmis",
            "30521" => "Le pays d'origine d'un article est incorrect",
            "30522" => "La Référence de l'article n'a pas été transmise",
            "30523" => "Le nombre max d’articles est dépassé (100 max)",
            "30524" => "La devise n'a pas été transmise",
            "30528" => "Le numéro de colis d'origine n’a pas été transmis",
            "30525" => "Le numéro de colis d’origine est incorrect",
            "30529" => "Le numéro de facture d'origine n’a pas été transmis",
            "30530" => "La date de la facture d'origine n’a pas été transmise",
            "30533" => "La date de facture d’origine doit être antérieure à la date du jour",
            "30531" => "Le nombre max de colis d’origine est dépassé ( 5 max )",
            "30532" => "Le numéro de facture est incorrect",
            "30534" => "L’identifiant du document est incorrect",
            "30535" => "La référence importateur est incorrecte",
            "30536" => "La valeur de marchandises est supérieure au seuil autorisé",
            "30537" => "La devise doit être identique pour l’ensemble des articles du colis",
            "30538" => "Le code pays doit être identique pour l’ensemble des articles du colis",
            "30539" => "Le commentaire est trop long",
            "30540" => "Le poids total des articles contenus dans votre envoi ne peut être supérieur au poids initialement déclaré pour le colis.",
            "30541" => "Un seul identifiant document doit être transmis",
            "30542" => "La catégorie de l'envoi est incorrecte",
            "30543" => "La Référence de l'article est incorrecte",
            "30544" => "La devise est incorrecte",
            "30546" => "Identifiant de facture et colis original n’a pas été transmis",
            "30547" => "Identifiant de facture et colis original inconnu ou incorrect",
            "30548" => "Article non rattaché à un colis et une facture",
            "30549" => "L’identifiant du colis et facture existe déjà",
            "30550" => "Il existe des doublons dans la liste des colis origine déclarée",
            "30551" => "La référence importateur n’a pas été transmise",
            "30552" => "n’a pas été transmis",
            "30553" => "La date de facturation doit être identique pour un même numéro de facture. Veuillez saisir une nouvelle date.",
            "30554" => "Au moins une déclaration de colis origine doit être transmise.",
            "30700" => "Le produit demandé n’existe pas dans le compte client",
            "30701" => "La plage utilisée est incorrecte",
            "30702" => "Ce numéro de colis a déjà été attribué à un colis il y a moins de 13 mois",
            "30703" => "La présence ou l’absence d’indication de plage n’est pas conforme à la solution souscrite.",
            "30704" => "Le produit transmis ne permet pas d'effectuer un service retour depuis l'international.",
            "30705" => "Le pays transmis n'est pas habilité à proposer le service retour depuis l'international.",
            "30800" => "Veuillez activer le dépôt en boite à lettres dans votre Back Office",
            "30801" => "Colis inexistant Le colis n’a pas été annoncé auprès de La Poste",
            "30802" => "Ce colis a déjà été pris en charge Le colis a déjà été pris en charge par La Poste",
            "30803" => "ous avez déjà pris rendez-vous Le colis a déjà fait l’objet d’une demande de d’emport en boite à lettres",
            "30804" => "Le produit retour n’est pas déposable en boite à lettre Le service de dépôt en boite à Lettres n’est pas disponible",
            "30805" => "e colis ne peut pas être déposé en boite à lettre L’adresse ne permet pas de faire une demande d’emport de colis déposé en boite à lettres",
            "30806" => "a date d’emport demandée est incorrecte La date d’emport demandée ne fait pas partie des prochaines dated’emport possibles à cette adresse",
            "30807" => "Le colis n’est pas autorisé à un dépôt en boîte aux lettres",
            "30808" => "Date emport invalide: vous n’avez pas activé le dépôt en boîte aux lettres dans votre Back Office",
            "30809" => "Veuillez ne pas indiquer de date d’emport si vous avez choisi l’option : étiquette non déposable en boîte aux lettres",
            "30810" => "Demande d’emport boîte aux lettres invalide : colis non déposable en boîte aux lettres",
            "30811" => "La date d’emport demandée est incorrecte",
            "30812" => "Aucune date d’emport trouvée pour cette adresse L’adresse ne permet pas de faire une demande d’emport de colis déposé en boite à lettres",
            "30813" => "La date d'emport n'a pas été transmise",
            "30814" => "Le nombre max de colis dépassé",
            "30815" => "Le nombre max de dates d'enlèvement dépassé",
            "30816" => "Impossible d'effectuer un dépôt en BAL avec les informations transmises. Un dépôt en BP est forcé",
            "30817" => "Le site de collecte n'a pas été transmis",
            "30818" => "Le site de collecte est incorrect",
            "30819" => "L’adresse n’est pas autorisée à une livraison dans la journée",
            "30820" => "Le service livraison en journée n’est pas possible à cette adresse.",
            "30900" => "Le nom du point retrait n'a pas été transmis",
            "30901" => "L’adresse du point retrait n'a pas été transmise",
            "30902" => "Le code postal du point retrait n'a pas été transmis",
            "30903" => "La ville du point retrait n'a pas été transmise",
            "30904" => "Le code pays du point retrait n'a pas été transmis",
            "40011" => "Erreur: code pays de destination du colis incorrect",
            "40012" => "Erreur: Pays non ouvert au service Retour Colissimo International ou incorrect. Contacter votre support client",
            "40013" => "Erreur: Relation pays expéditeur et pays de destination non ouverte ou incorrecte. Contacter votre support client",
            "40014" => "Erreur: Plage de numéros de colis épuisée. Contacter votre support client",
            "40015" => "Service momentanément indisponible",
            "40016" => "Problème de paramétrage de seuil. Le pays d’origine {0} n’existe pas",
            "40017" => "Les informations transmises semblent incohérentes : impossible deréaliser un affranchissement. Merci de contacter le support client si le problème persiste.",
            "40018" => "Service non disponible. Contacter votre support client.",
            "14040" => "Les options assurance et recommandation ne sont pas compatibles. Veuillez sélectionner une ou l'autre de ces options."
            ];
    }
}