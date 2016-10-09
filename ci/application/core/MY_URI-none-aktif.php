<?php
/**
* Modified URI class to enable multiple URL suffixes,
* and a function to retrieve which one is used.
* Separate the suffixes with commas (,).
*/
class MY_URI extends CI_URI{
    /**
     * Remove the suffix from the URL if needed, if a suffix is found, save it in $this->url_suffix.
     *
     * @access    private
     * @return    void
     */    
    function _remove_url_suffix()
    {
        $this->url_suffix = '';
        if  ($this->config->item('url_suffix') != ""){
            // go through every suffix and see if they match
            $suffixes = explode(',',$this->config->item('url_suffix'));
            foreach($suffixes as $suffix){
                $suffix = trim($suffix);
                if(preg_match("|".preg_quote($suffix)."$|", $this->uri_string)){
                    // We have match, remove the suffix and save which one in $this->url_suffix
                    $this->uri_string = preg_replace("|".preg_quote($suffix)."$|", "", $this->uri_string);
                    $this->url_suffix = $suffix;
                    break;
                }
            }
        }
    }
    /**
     * Returns the URL suffix used for this request.
     * @return string
     */
    function get_extension(){
		$this->_remove_url_suffix();
        return $this->url_suffix;
    }
}