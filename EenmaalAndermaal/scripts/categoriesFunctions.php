<?php
//rubriekenboom
//TESTEN
function getCategoryOverview($databasehandler)

{
    set_time_limit(300);
    $previousCategoryNumber = 0;
    $alphabet = range('A', 'Z');
    $categoryOverview = "";
    //TODO: iets.php veranderen naar werkelijke pagina.
    $referenceSite = "iets.php?categoryID=";
    $mainCategoryQuery = "SELECT HoofdrubriekNr = h.Rubrieknummer,	HoofdrubriekNaam = h.Rubrieknaam FROM Rubriek h WHERE h.Parent = -1 AND h.Rubrieknaam LIKE '";
    $subCategoryCountQuery = "SELECT TOP(10) COUNT(*) FROM	Rubriek h LEFT JOIN Rubriek s on h.Rubrieknummer = s.Parent WHERE s.Parent =";
    $subCategoryQuery = "SELECT TOP(10) SubrubriekNr=s.Rubrieknummer, SubrubriekNaam=s.Rubrieknaam FROM	Rubriek h LEFT JOIN Rubriek s on h.Rubrieknummer = s.Parent WHERE s.Parent = ";
    $subCategoryLevel1CountQuery = "SELECT TOP(10) COUNT(*) FROM Rubriek h LEFT JOIN Rubriek s on h.Rubrieknummer=s.Parent LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Parent WHERE s1.Parent =";
    $subCategoryLevel1Query = "SELECT TOP(10) SubrubriekNiveau1Nr = s1.Rubrieknummer, SubrubriekNiveau1Naam = s1.Rubrieknaam FROM Rubriek h LEFT JOIN Rubriek s on h.Rubrieknummer=s.Parent LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Parent WHERE s1.Parent =";
    $subCategoryLevel2CountQuery = "SELECT TOP(10) COUNT(*) FROM Rubriek h LEFT JOIN Rubriek s on h.Rubrieknummer=s.Parent LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Parent LEFT JOIN Rubriek s2 on s1.Rubrieknummer = s2.Parent  WHERE s2.Parent =";
    $subCategoryLevel2Query = "SELECT TOP(10) SubrubriekNiveau2Nr = s2.Rubrieknummer, SubrubriekNiveau2Naam = s2.Rubrieknaam FROM Rubriek h LEFT JOIN Rubriek s on h.Rubrieknummer=s.Parent LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Parent LEFT JOIN Rubriek s2 on s1.Rubrieknummer = s2.Parent  WHERE s2.Parent =";
    $subCategoryLevel3CountQuery = "SELECT TOP(10) COUNT(*) FROM Rubriek h LEFT JOIN Rubriek s on h.Rubrieknummer=s.Parent LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Parent LEFT JOIN Rubriek s2 on s1.Rubrieknummer = s2.Parent LEFT JOIN Rubriek s3 on s2.Rubrieknummer = s3.Parent WHERE s3.Parent =";
    $subCategoryLevel3Query = "SELECT TOP(10) SubrubriekNiveau3Nr = s3.Rubrieknummer, SubrubriekNiveau3Naam = s3.Rubrieknaam FROM Rubriek h LEFT JOIN Rubriek s on h.Rubrieknummer=s.Parent LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Parent LEFT JOIN Rubriek s2 on s1.Rubrieknummer = s2.Parent LEFT JOIN Rubriek s3 on s2.Rubrieknummer = s3.Parent WHERE s3.Parent =";
    $categoryOverview .= '<div uk-grid>';
    foreach ($alphabet as $letter) {
        $categoryOverview .= '<div id="'.$letter.'">';
        $mainCategoriesData = $databasehandler->query($mainCategoryQuery.$letter."%'");
        while ($mainCategoryRow = $mainCategoriesData->fetch()) {
            //TODO: UIkit element gebruiken ipv section met class
            $categoryOverview .= '<h3>' . $mainCategoryRow['HoofdrubriekNaam'] . '</h3>';
            $previousCategoryNumber = $mainCategoryRow['HoofdrubriekNr'];
            if ($countSubCategory = $databasehandler->query($subCategoryCountQuery. $previousCategoryNumber)) {
                if ($countSubCategory->fetchColumn() > 0) {
                    $subCategoryData = $databasehandler->query($subCategoryQuery . $previousCategoryNumber);
                    $categoryOverview .= '<ul class="uk-list">';
                    while ($subCategoryRow = $subCategoryData->fetch()) {
                        $categoryOverview .= '<li><a class="uk-button-default" href="'.$referenceSite.' '.$subCategoryRow['SubrubriekNr'] . '">' . $subCategoryRow['SubrubriekNaam'] . '</a>';
                        $previousCategoryNumber = $subCategoryRow['SubrubriekNr'];
                        if ($countSubCategoryLevel1 = $databasehandler->query($subCategoryLevel1CountQuery.$previousCategoryNumber)) {
                            if ($countSubCategoryLevel1->fetchColumn() > 0) {
                                $categoryOverview .= '<div uk-dropdown><ul class="uk-list uk-nav uk-dropdown-nav">';
                                $subCategoryLevel1Data = $databasehandler->query($subCategoryLevel1Query. $previousCategoryNumber);
                                while ($subCategoryLevel1Row = $subCategoryLevel1Data->fetch()) {
                                    $previousCategoryNumber = $subCategoryLevel1Row['SubrubriekNiveau1Nr'];
                                    $categoryOverview .= '<li><a href="'.$referenceSite.$subCategoryLevel1Row['SubrubriekNiveau1Nr'].'">'.$subCategoryLevel1Row['SubrubriekNiveau1Naam'].'</a>';
                                    if($countSubCategoryLevel2 = $databasehandler->query($subCategoryLevel2CountQuery.$previousCategoryNumber)){
                                        if($countSubCategoryLevel2->fetchColumn() > 0){
                                            $categoryOverview .= '<ul>';
                                            $subCategoryLevel2Data = $databasehandler->query($subCategoryLevel2Query.$previousCategoryNumber);
                                            while($subCategoryLevel2Row = $subCategoryLevel2Data->fetch()){
                                                $previousCategoryNumber = $subCategoryLevel2Row['SubrubriekNiveau2Nr'];
                                                $categoryOverview .= '<li><a href="'.$referenceSite.$subCategoryLevel2Row['SubrubriekNiveau2Nr'].'">'.$subCategoryLevel2Row['SubrubriekNiveau2Naam'].'</a>';
                                                if($countSubCategoryLevel3 = $databasehandler->query($subCategoryLevel3CountQuery.$previousCategoryNumber)){
                                                    if($countSubCategoryLevel3->fetchColumn() > 0){
                                                        $categoryOverview .= '<ul class="uk-list">';
                                                        $subCategoryLevel3Data = $databasehandler->query($subCategoryLevel3Query.$previousCategoryNumber);
                                                        while($subCategoryLevel3Row = $subCategoryLevel3Data->fetch()){
                                                            $previousCategoryNumber = $subCategoryLevel3Row['SubrubriekNiveau3Nr'];
                                                            $categoryOverview .= '<li><a href="'.$referenceSite.$subCategoryLevel3Row['SubrubriekNiveau3Nr'].'">'.$subCategoryLevel3Row['SubrubriekNiveau3Naam'].'</a></li>';
                                                        }
                                                        $categoryOverview .= '</ul>';
                                                    }
                                                }
                                            $categoryOverview .= '</div></li>';
                                            }
                                            $categoryOverview .= '</ul>';
                                        }
                                    }

                                    $categoryOverview.= '</li>';
                                }
                                $categoryOverview .= '</ul>';
                            }
                        }
                        $categoryOverview .='</li>';
                    }
                    $categoryOverview .= '</ul>';
                }
            }
            //TODO: UIkit element gebruiken ipv section met class
            //left join, hoofdrubriek op subrubriek

        }
        $categoryOverview .= '</div>';
    }
    $categoryOverview .='</div>';
    return $categoryOverview;
}

function getHomepageCategoryOverview($databasehandler, $overviewSize)
{
    $homepageCategoryOverview = "";
    //TODO: Voorwerp_in_Rubriek aanpassen?
    $mainCategoriesData = $databasehandler->query("SELECT TOP" . $overviewSize . " rubrieknummer, rubrieknaam  FROM Rubriek r WHERE rubrieknummer IN (SELECT count(*), rubrieknummer FROM Voorwerp_in_Rubriek GROUP BY rubrieknummers ORDER BY count(*)))");
    while ($mainCategoryRow = $mainCategoriesData->fetch()) {
        $homepageCategoryOverview .= '<a href="iets.php?categoryID=' . $mainCategoryRow['rubrieknummer'] . '">' . $mainCategoryRow['rubrieknaam'] . '</a>';
    }
    return $homepageCategoryOverview;
}

function getAlphabetList()
{
    $alphabet = range('A', 'Z');
    $alphabetList = '<ul class="uk-pagination">';
    foreach ($alphabet as $letter) {
        $alphabetList .= '<li><a href="">' . $letter . '</a></li>';
    }
    $alphabetList .= '</ul>';
    return $alphabetList;
}

?>


