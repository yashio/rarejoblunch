<?php

Class Shop extends EMongoDocument
{
	/*住所*/
	public $address;
	/*感想*/
	public $impression;
	/*店舗名*/
	public $name;
	/*緯度*/
	public $lat;
	/*軽度*/
	public $lng;
	/*種別*/
	public $kind;

	// This has to be defined in every model, this is same as with standard Yii ActiveRecord
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
      }
 
      // This method is required!
      public function getCollectionName()
      {
        return 'shops';
      }
 
      public function rules()
      {
        return array(
#          array('login, pass', 'required'),
#          array('login, pass', 'length', 'max' => 20),
          array('name', 'length', 'max' => 255),
        );
      }
 
      public function attributeLabels()
      {
        return array(
          'lat'  => '緯度',
          'lng'  => '経度',
          'name'   => '店舗名',
          'address'   => '住所',
          'kind'   => '種別',
        );
      }
    }
?>
