<?hh

use Pi\MockHost;
use Pi\Odm\OdmPlugin;
use Pi\Interfaces\IContainer;
use Pi\FileSystem\FileSystemService;
use Pi\FileSystem\FileSystemPlugin;
use Pi\FileSystem\FileSystemConfiguration;
use Pi\Uml\PiUmlPlugin;
use SpotEvents\SpotEventsPlugin;
use Pi\Service;
use Pi\Response;
use Pi\ServiceInterface\Data\ArticleRepository;
use SpotEvents\ServiceInterface\Data\EventRepository;
use SpotEvents\ServiceInterface\Data\NutritionRepository;
use SpotEvents\ServiceInterface\Data\ModalityRepository;

require 'vendor/autoload.php';

class MongoCursorException extends \Exception {

}

class LocalHost extends MockHost {

  public function configure(IContainer $container)
  {
    header('P3P: policyref="/w3c/p3p.xml", CP="ALL IND DSP COR ADM CONo CUR CUSo IVAo IVDo PSA PSD TAI TELo OUR SAMo CNT COM INT NAV ONL PHY PRE PUR UNI"');
  	$this->config()->domain('localhost');
    $this->config()->protocol('http');
    
  	$conf = new FileSystemConfiguration();
  	$conf->storeDir(__DIR__ . '/cdn');
  	$this->config()->staticFolder(__DIR__ . '/cdn');

  	$this->registerPlugin(new FileSystemPlugin($conf));
  	$this->registerPlugin(new PiUmlPlugin());
  	$this->registerPlugin(new SpotEventsPlugin());

    $db = $container->get('OdmConfiguration');
    $db->setDefaultDb('viseu-app');
    $db->setHostname('ds1.codigo.ovh');
  }
}

$host = new LocalHost();
$host->init();

$crawler = $host->container()->get('Pi\ServiceInterface\WordpressCrawler');
$crawler->fetch('http://noticiasdeviseu.com', 0, 50, 'Noticias de Viseu', 'http://noticiasdeviseu.com', 'http://www.diarioviseu.pt/logos/diario_viseu.png');
$crawler->fetch('http://noticiasdeviseu.com', 50, 100, 'Noticias de Viseu', 'http://noticiasdeviseu.com', 'http://www.diarioviseu.pt/logos/diario_viseu.png');