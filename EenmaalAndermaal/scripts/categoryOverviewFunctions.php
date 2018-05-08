<?php
//rubriekenboom
//TESTEN
function getCategoryOverview($databasehandler)

{
    set_time_limit(300);
    $previousMainCategoryNumber = 0;
    $previousSubCategoryNumber = 0;
    $previousSubCategoryLevel1Number = 0;
    $previousSubCategoryLevel2Number = 0;
    $previousSubCategoryLevel3Number = 0;
    $previousSubCategoryLevel4Number = 0;
    $previousCategoryKind = 0; //houdt bij welk soort de vorige geplaatse category is: 1 voor hoofd, 2 voor sub, 3 voor subniveau1, 4 voor subniveau2, 5 voor subniveau3, 6 voor subniveau4
    $alphabet = range('A', 'Z');
    $categoryOverview = "";
//TODO: iets.php veranderen naar werkelijke pagina.
    $referenceSite = "category.php?categoryID=";
    $query = "SELECT
HoofdrubriekNr=h.Rubrieknummer,
HoofdrubriekNaam=h.Rubrieknaam,
SubrubriekNr=s.Rubrieknummer,
SubrubriekNaam=s.Rubrieknaam,
SubrubriekNiveau1Nr=s1.Rubrieknummer,
SubrubriekNiveau1Naam=s1.Rubrieknaam,
SubrubriekNiveau2Nr=s2.Rubrieknummer,
SubrubriekNiveau2Naam=s2.Rubrieknaam,
SubrubriekNiveau3Nr=s3.Rubrieknummer,
SubrubriekNiveau3Naam=s3.Rubrieknaam,
SubrubriekNiveau4Nr=s4.Rubrieknummer,
SubrubriekNiveau4Naam=s4.Rubrieknaam

FROM Rubriek h
LEFT JOIN Rubriek s on h.Rubrieknummer=s.Parent
LEFT JOIN Rubriek s1 on s.Rubrieknummer = s1.Parent
LEFT JOIN Rubriek s2 on s1.Rubrieknummer = s2.Parent
LEFT JOIN Rubriek s3 on s2.Rubrieknummer = s3.Parent
LEFT JOIN Rubriek s4 on s3.Rubrieknummer = s4.Parent

WHERE h.Parent = -1 --AND h.Rubrieknaam LIKE '%a' 
ORDER BY h.Volgnr, h.Rubrieknaam, s.Volgnr, s.Rubrieknaam,  s1.Volgnr, s1.Rubrieknaam, s2.Volgnr, s2.Rubrieknaam, s3.Volgnr, s3.Rubrieknaam, s4.Volgnr, s4.Rubrieknaam";

    $categoryOverview .= '<div class="uk-flex" uk-grid>';
    $data = $databasehandler->query($query);
    while ($row = $data->fetch()) {
        if ($previousMainCategoryNumber != $row['HoofdrubriekNr']) {
            $categoryOverview .= getClosingTags($previousCategoryKind, 1);
            $previousCategoryKind = 1;
            $categoryOverview .= '<div class="uk-flex uk-flex-column uk-margin-left"><h4><a href="' . $referenceSite . $row['HoofdrubriekNr'] . '">' . $row['HoofdrubriekNaam'] . '</a></h4><ul class="uk-nav-default uk-nav-parent-icon" uk-nav uk-grid>';
        }
        if ($previousSubCategoryNumber != $row['SubrubriekNr']) {
            $categoryOverview .= getClosingTags($previousCategoryKind, 2);
            $previousCategoryKind = 2;
            $categoryOverview .= '<li class="uk-parent"><a href="#">' . $row['SubrubriekNaam'] . '<ul class="uk-nav-sub"><li><a class="uk-button uk-button-default" href="' . $referenceSite . $row['SubrubriekNr'] . '">Ga naar categorie</a></li>';
        }
        if ($previousSubCategoryLevel1Number != $row['SubrubriekNiveau1Nr']) {
            $categoryOverview .= getClosingTags($previousCategoryKind, 3);
            $previousCategoryKind = 3;
            $categoryOverview .= '<li><a class="uk-button uk-button-default" href="' . $referenceSite . $row['SubrubriekNiveau1Nr'] . '">' . $row['SubrubriekNiveau1Naam'] . '</a></li><div uk-dropdown><ul class="uk-list">';
        }
        if ($previousSubCategoryLevel2Number != $row['SubrubriekNiveau2Nr']) {
            $categoryOverview .= getClosingTags($previousCategoryKind, 4);
            $previousCategoryKind = 4;
            $categoryOverview .= '<li><a href="' . $referenceSite . $row['SubrubriekNiveau2Nr'] . '">' . $row['SubrubriekNiveau2Naam'] . '</a></li>';
        }

        $previousMainCategoryNumber = $row['HoofdrubriekNr'];
        $previousSubCategoryNumber = $row['SubrubriekNr'];
        $previousSubCategoryLevel1Number = $row['SubrubriekNiveau1Nr'];
        $previousSubCategoryLevel2Number = $row['SubrubriekNiveau2Nr'];
        $previousSubCategoryLevel3Number = $row['SubrubriekNiveau3Nr'];
        $previousSubCategoryLevel4Number = $row['SubrubriekNiveau4Nr'];
    }


    $categoryOverview .= '</div>';
    return $categoryOverview;
}

function getClosingTags($previousCategoryKind, $currentCategoryKind)
{
    $closingTags = "";
    switch ($currentCategoryKind) {
        case 1:
            switch ($previousCategoryKind) {
                case 1:
                    $closingTags .= '</div>';
                    break;
                case 2:
                    $closingTags .= '</ul></li></div>';
                    break;
                case 3:
                    $closingTags .= '</div></ul></li></ul></div>';
                    break;
                case 4:
                    $closingTags .= '</div></ul></li></ul></div>';
                    break;
                case 5:
                    $closingTags .= '</div></ul></li></ul></div>';
                    break;
                case 6:
                    $closingTags .= '</div></ul></li></ul></div>';
                    break;
            }
            break;
        case 2:
            switch ($previousCategoryKind) {
                case 2:
                    $closingTags .= '</ul></li>';
                    break;
                case 3:
                    $closingTags .= '</div></ul>';
                    break;
                case 4:
                    $closingTags .= '</div></ul>';
                    break;
                case 5:
                    $closingTags .= '</div></ul>';
                    break;
                case 6:
                    $closingTags .= '</div></ul>';
                    break;
            }
            break;
        case 3:
            switch ($previousCategoryKind) {
                case 3:
                    $closingTags .= '</div>';
                    break;
                case 4:
                    $closingTags .= '</div>';
                    break;
                case 5:
                    $closingTags .= '';
                    break;
                case 6:
                    $closingTags .= '';
                    break;
            }
            break;
        case 4:
            switch ($previousCategoryKind) {
                case 4:
                    $closingTags .= '';
                    break;
                case 5:
                    $closingTags .= '';
                    break;
                case 6:
                    $closingTags .= '';
                    break;
            }
            break;
        case 5:
            switch ($previousCategoryKind) {
                case 5:
                    $closingTags .= '';
                    break;
                case 6:
                    $closingTags .= '';
                    break;
            }
            break;
        case 6:
            $closingTags .= '';
            break;
    }

    return $closingTags;
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
        $alphabetList .= '<li><a href="#' . $letter . '">' . $letter . '</a></li>';
    }
    $alphabetList .= '</ul>';
    return $alphabetList;
}

?>


