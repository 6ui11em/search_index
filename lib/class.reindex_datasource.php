<?

Class ReindexDataSource extends Datasource{
	
	public $dsParamROOTELEMENT = 'reindex';
	public $dsSource = NULL;
	
	public $dsParamORDER = 'asc';
	public $dsParamLIMIT = '20';
	public $dsParamREDIRECTONEMPTY = 'no';
	public $dsParamSORT = 'system:id';
	public $dsParamSTARTPAGE = '1';

	public $dsParamLANGUAGE = '';
	
	public $dsParamINCLUDEDELEMENTS = array('system:pagination');
	public $dsParamASSOCIATEDENTRYCOUNTS = 'no';		
	
	public function __construct(&$parent, $env=NULL, $process_params=TRUE){
		parent::__construct($parent, $env, $process_params);
	}
	
	public function getSource(){
		return $this->dsSource;
	}
	
	public function grab(&$param_pool){
		
		if (isset($_GET['page'])) $this->dsParamSTARTPAGE = $_GET['page'];			
		$this->dsParamLIMIT = $this->_Parent->Configuration->get('re-index-per-page', 'search_index');
		
		$result = new XMLElement($this->dsParamROOTELEMENT);
		
		try{
			include(EXTENSIONS . '/search_index/data-sources/datasource.section.php');
		}
		catch(Exception $e){
			$result->appendChild(new XMLElement('error', $e->getMessage()));
			return $result;
		}
		if($this->_force_empty_result) $result = $this->emptyXMLSet();

		return $result;		

	}
	
}