<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 12/2/18
 * Time: 12:06 AM
 */

namespace App\Command;


use App\Service\Files\FilesServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearExpiredFiles extends Command {

	private $service;

	public function __construct( ?string $name = null, FilesServiceInterface $service ) {
		parent::__construct( $name );

		$this->service = $service;

	}

	public function configure() {
		$this->setName( 'app:clear:files:expired' )
		     ->setDescription( 'Clear expire files. Hard delete on -10% file life time' )
		     ->addArgument( 'limit', InputArgument::OPTIONAL, 'Limit records to clear' );
	}

	public function execute( InputInterface $input, OutputInterface $output ) {

		$limit = $input->getArgument('limit') ?? 100;

		$output->writeln( \sprintf("Start clearing files (limit %d)",$limit) );

		$files = $this->service->getDeletedExpired($limit);
		$count = count($files);

		$output->writeln( \sprintf("Find %d results",$count) );

		if($count > 0){

			$removed = 0;

			foreach ($files as $file){

				if($file->getTimeLeft() < -10){

					$removed++;
					$this->service->remove($file,false);

				}

			}

			$output->writeln( sprintf("Removed: %d",$removed) );

		}

		$output->writeln( "Finish clearing" );

	}


}