<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * 
 	#######################################
	#     AACGC Download Tracker          #                
	#     by M@CH!N3                      #
	#     http://www.AACGC.com            #
	#######################################
 *
 */

if (!defined('e107_INIT')) {
    exit;
}

class top_downloads_list
{
    protected $plugPrefs = array();
    protected $amount;
    protected $category = 0;


    public function __construct()
    {
        $this->plugPrefs = e107::getPlugPref('download_extended');
    }
  

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
 
    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function setPeriod($period)
    {
        $this->period = $period;
    }
    
    public function getTopDownloadsData()
    {
        $qry = " AND find_in_set(download_visible,'" . USERCLASS_LIST . "')  ";

        $q_cat = $q_date = '';
        if ($this->category > 0) {
            $q_cat = " AND d.download_category = ".$this->category;
        }
        if ($this->period > 0) {
            $s_date	= time();
            $period = 7 == $this->period ? date('w', $s_date)-1 : date('j', $s_date)-1;
            if (0 > $period) {
                $period = 6;
            }									
			# $period = -1, if first day of the week, = 0 if first day of the month
            $e_date	= strtotime(date('d F Y', $s_date)) - ($period*86400);	# How mant days backwards
            $q_date	= "
			AND
				dr.download_request_datestamp > {$e_date}
			AND
				dr.download_request_datestamp < {$s_date}";
        }

        $qry = "SELECT d.*, dc.*, 
			COUNT(dr.download_request_id) as download_this_period_count
			FROM #download AS d
			LEFT JOIN #download_category AS dc ON d.download_category=dc.download_category_id
			INNER JOIN #download_requests as dr ON d.download_id = dr.download_request_download_id
			WHERE 
			d.download_active > '0' ".$qry." ".$q_cat." ".$q_date." 
			GROUP BY
				dr.download_request_download_id
			ORDER BY
				download_this_period_count DESC
			LIMIT 0,".intval($this->amount)." ";
          
        $downloads = e107::getDB()->retrieve($qry, true);
             
        return $downloads;
    }


	public function setWhatIsDisplayed($template = '') {
        if(!$this->plugPrefs['menu_latest_category'])  $search[] = '{DOWNLOAD_CATEGORY}';
		if(!$this->plugPrefs['menu_latest_date'])  $search[] = '{DOWNLOAD_VIEW_DATE_SHORT}';
		if(!$this->plugPrefs['menu_latest_author'])  $search[] = '{DOWNLOAD_LIST_AUTHOR}';
		if(!$this->plugPrefs['menu_latest_adminlink'])  $search[] = '{DOWNLOAD_ADMIN_EDIT}';
		if(!$this->plugPrefs['menu_latest_description'])  $search[] = '{DOWNLOAD_VIEW_DESCRIPTION}';
		if(!$this->plugPrefs['menu_latest_description'])  $search[] = '{JMDOWNLOAD_META_DESCRIPTION}';
		if(!$this->plugPrefs['menu_latest_size'])  $search[] = '{DOWNLOAD_LIST_FILESIZE}';
 
		$replace = '';
		$template = str_replace($search, $replace, $template);
	 
		return $template;

	}

}
