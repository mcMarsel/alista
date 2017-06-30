<?php

class Prods extends \Eloquent
{
    protected $table = 'prods';

    protected $fillable = ['ProdID', 'ProdName', 'UM', 'Weight', 'Country', 'Notes', 'PCatID', 'PGrID', 'Article1', 'Article2', 'Article3', 'Weight', 'Age', 'TaxPercent', 'PriceWithTax', 'Note1', 'Note2', 'Note3', 'MinPriceMC', 'MaxPriceMC', 'MinRem', 'CstDty', 'CstPrc', 'CstExc', 'StdExtraR', 'StdExtraE', 'MaxExtra', 'MinExtra', 'UseAlts', 'UseCrts', 'PGrID1', 'PGrID2', 'PGrID3', 'PGrAID', 'PBGrID', 'LExpSet', 'EExpSet', 'InRems', 'IsDecQty', 'File1', 'File2', 'File3', 'AutoSet', 'Extra1', 'Extra2', 'Extra3', 'Extra4', 'Extra5', 'Norma1', 'Norma2', 'Norma3', 'RecMinPriceCC', 'RecMaxPriceCC', 'RecStdPriceCC', 'RecRemQty', 'InStopList', 'PrepareTime', 'Tariff_Code', 'Customs_Code', 'ShortProdName', 'ProdName_ENG', 'UAProdName', 'ProductionDate', 'OldProdName', 'ScaleGrID', 'ScaleStandard', 'ScaleConditions', 'ScaleComponents', 'GrGTD', 'TaxType', 'TaxFreeReason', 'CstProdCode', 'TName'];
}