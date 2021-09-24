<?php 
declare(strict_types=1);

namespace Library\Classes;

class RecipeFromForm extends Recipe {

    

    public function validate (array $post) : ?array 
    {
        $errors = [
        ];

        $required = [ 'title', 'image', 'meal', 'diet', 'content'];

        foreach($required as $input) {
            if(empty($post[$input]) ) {
                array_push($errors, $input);
            }
        }

        if (empty($errors)) {  // on success;
            $this->newRecipe($post);
            return null;
        }

        return $errors; // on error
                      
    }

    protected function newRecipe (array $post) : void 
    {
       
        $recipes_folder = $_SERVER["DOCUMENT_ROOT"].'/recipes/';

        $meal = $post['meal'];
        $recipe_file_name = $this->slugify($post['title']);
        $recipe_content = $post['content'];
        $diet = $post['diet'];
        $autodelete = '';

        if ($this->autodelete) {
           $autodelete =
    '"autodelete" : "true",
    "timestamp" : "'.time().'"';
        } else {
            $autodelete = '';
        }


        $diet_txt =
'vege        []
pescovege   []
with meat   []';

        $diet = preg_replace('/^('.$diet.')(\s*)(\[])/m', '$1$2[x]', $diet_txt);

        $content =
'{
    "title" : "'.trim($post['title']).'",
    "image" : "'.trim($post['image']).'",
    '.$autodelete.'
}
===
'.$recipe_content.'
===
# Diet
'.$diet.'
===
# Tags: 
'.trim($post['tags']).'
===
# Type:
'.trim($post['types']).'
';
        
        $file = fopen($recipes_folder.$meal.'/'.$recipe_file_name.'.md', 'a');
        fwrite($file, $content);
        fclose($file);

        foreach($_POST as $input=>$value) {
            unset($_POST[$input]);
        }

    }


    public function slugify(string $string) : string
    {
        $string = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $string);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
    }
    

}