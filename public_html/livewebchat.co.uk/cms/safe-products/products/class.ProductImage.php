<?
	class ProductImage extends SortableModel {
		function __construct($obj=null){
			parent::__construct($obj,'product_image');
			$this->doInternalSQL();
			$this->hasOne('product');
			$size = Config::value('news-homepage-width','site');
			$this->hasFile('image',array('file_type'=>'img',
				'extraSizes'=>array(
					'home'=>array( 'width'=>$size,'height'=>$size, 'resizer'=>'ImageResizerFitAndPad' ,),
					'detail'=>array( 'width'=>300,'resizer'=>'ImageResizerFitAndPad' ,),
					'list'=>array( 'width'=>168,'resizer'=>'ImageResizerCropSquare' ,),
					'icon'=>array( 'width'=>50,'height'=>50, 'resizer'=>'ImageResizerCropSquare' ,),
					
					'prodThumbHome'=>array('width'=>90,'height'=>90, 'resizer'=>'ImageResizerFitInBounds'),
					'prodThumb'=>array('width'=>110,'height'=>110, 'resizer'=>'ImageResizerFitInBounds'),
					'prodDetail'=>array('width'=>400,'height'=>400, 'resizer'=>'ImageResizerFitInBounds'),
				)
			));
		}

		function getLabelField(){
			return "caption";
		}
		function filter_fields_built($fields){
			unset($fields['name']);
			unset($fields['status']);
			unset($fields['slug']);
			$fields['caption'] = new Field('caption');
			$fields['image']->setParam('delete',false);
			return $fields;
		}
	}
?>
