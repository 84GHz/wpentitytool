<?php
namespace Wpentitytool;

class App
{
    public function runCommand(array $argv)
    {
        
        if ($argv[1] == "fields") {

            $plugin_base = dirname( __FILE__, 3 ); 
            $includes_path = $plugin_base . '/includes';
            $metaboxes_path = $includes_path . '/dynamicmetaboxes.php';

            if (!file_exists($includes_path)) { mkdir($includes_path, 0777, true); }
            if (!file_exists($metaboxes_path)) { 
              echo "Metaboxes Library nicht da, kopiere... \n"; 
              $source_loc = $plugin_base . '/wpentitytool/assetsdata/dynamicmetaboxes.php'; 
              //echo(dirname(__DIR__, 1));            

              //echo $source_loc;
              copy($source_loc, $metaboxes_path);
            }
            echo ("Generating fields .php file \n");    
            $continue_loop = true;
            $file_render_array = [];
            $post_type = $this->consoleAskSingleFieldPart('Post Typ maschineller Name: '); 
            while($continue_loop){
              $subarray;
              $subarray['field_label'] = $this->consoleAskSingleFieldPart('Feldbezeichnung eingeben (enter zum Aufhören) : ');
              if(!($subarray['field_label'])) {
              break;
              }
              $subarray['field_machine_name'] = $this->consoleAskSingleFieldPart('Feld maschinenlesbarer Name: ');
              $subarray['field_description'] = $this->consoleAskSingleFieldPart('Feldbeschreibung: ');
              $subarray['post_type'] = $post_type;

              $outputfile = $includes_path . '/' . $post_type . '-fields.php';

              $subarray['field_type'] = $this->consoleAskSingleFieldPart('Feldtyp angeben [textfield|textarea|checkbox|datepicker|mediabox|otmreference]: ' );
              array_push($file_render_array, $subarray);
          }        
          $template_file = __DIR__ . '/templates/fields-template.php';
          $output.= $this->loopTemplate( $template_file, $file_render_array );
          echo $output;
          $handle = fopen($outputfile, 'w') or die('Cannot open file:  '.$outputfile); //implicitly creates file

          fwrite($handle, $output);
          fclose($handle);

          echo "Bitte die Zeile : \n\n";
          echo 'include (__DIR__ . "/includes/' . $post_type . '-fields.php");' . "\n\n";
          echo "zur Hauptplugindatei hinzufügen \n";
 
          //var_dump($file_render_array);
        }
        else {
            echo ("Generating Module File \n");
            $default_args =  array( 'name_singular' => "Benutzerdefinierter Post", 
            'name_machine' => 'custom_post', 
            'menu_position' => 5 );
            $args;
            $args['name_singular'] = $this->consoleAsk("Name des Post-Typs im Singular", $default_args['name_singular']);            
            $args['name_machine'] = $this->consoleAsk("Maschinen-Lesbarer-Name des Post-Typs im Singular", $default_args['name_machine']);            
            $args['menu_position'] = $this->consoleAsk("Position des Post-Typs im Menu", $default_args['menu_position']);            


             $file = __DIR__ . '/templates/cpt-template.php';
             $output.= $this->template( $file, $args );
             echo ($output);
             $outputfile = __DIR__ . '/../../av-' . $args['name_machine'] . '-type.php';
             //echo $outputfile;
             $handle = fopen($outputfile, 'w') or die('Cannot open file:  '.$outputfile); //implicitly creates file

             fwrite($handle, $output);
             fclose($handle);

             echo "Bitte die Zeile : \n\n";

             echo 'include (__DIR__ . "/av-' .  $args['name_machine'] . '-type.php");' . "\n\n";

          echo "zur Hauptplugindatei hinzufügen \n";

        }





       



        /**
        * Simple Templating function
        *
        * @param $file   - Path to the PHP file that acts as a template.
        * @param $args   - Associative array of variables to pass to the template file.
        * @return string - Output of the template file. Likely HTML.
        */




    }
        /**
         * gets input from the console and returns it
         * 
         */
        public function consoleAsk($question, $default = false) {
            echo $question . "[" . $default . "]:";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $ff = trim($line);            
            if($ff === ''){
                if($default) {
                    return $default;
                    exit;
                }         
                
            }
            else {
                return trim($line);
                exit;
            }

        }  

        /**
         * sinle field, return array or false to break loop
         */

            public function consoleAskSingleFieldPart($question) {            
            echo $question;
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $ff = trim($line);            
            if($ff === ''){                
                  return false;                 
                
            }
            else {
                return $ff;
                
            }

        }  
         public function template( $file, $args ){
       
       // $file = __DIR__ . '/templates/cpt-template.php';
      // ensure the file exists
        if ( !file_exists( $file ) ) {
        return '';
      }
  
      // Make values in the associative array easier to access by extracting them
      if ( is_array( $args ) ){
        extract( $args );
      }
  
      // buffer the output (including the file is "output")
      ob_start();
        include $file;
      return ob_get_clean();
    }  
    public function loopTemplate( $file, $args ){
       
      // $file = __DIR__ . '/templates/cpt-template.php';
     // ensure the file exists
       if ( !file_exists( $file ) ) {
       return '';
     }    
     
 
     // buffer the output (including the file is "output")
     ob_start();
       include $file;
     return ob_get_clean();
   }   
} 
?>