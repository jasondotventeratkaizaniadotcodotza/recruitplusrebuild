<?php

class FeedController extends Zend_Controller_Action
{

    public function init()
    {
        Zend_Layout::getMvcInstance()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->em = Zend_Registry::get('em');
    }

    public function indexAction()
    {
        
    }

    public function rssAction()
    {
        $feed = new Zend_Feed_Writer_Feed();
        $feed->setTitle('Job Listing Feeds');
        $feed->setDescription('description');
        $feed->setLink('http://recruit.vagrant/feed/rss');
        $feed->setEncoding('utf8');
        $feed->addCategory(array(
            'term' => 'Job Listings'
        ));
        $jobListingHelper = new RM_Action_Helper_JobListings();
        $jobListings = $jobListingHelper->getAllJobListings($this->em);
        if (!empty($jobListings)) {
            foreach ($jobListings as $jobListing) {
                $entry = $feed->createEntry();
                $entry->setDescription($jobListing['description']);
//            $entry->setContent($content);
                $entry->setDateCreated();
                $entry->setId((string) $jobListing['id']);
                $entry->setLink('http://recruit.vagrant/job-listing/view?j=' . $jobListing['id']);
                $entry->setTitle($jobListing['title']);
                $entry->setType('rss');
                $entry->addCategories(array(
                    array(
                        'term' => $jobListing['advertisedBy']->getName(),
                    ),
                    array(
                        'term' => $jobListing['jobListingType']->getName(),
                    ),
                    array(
                        'term' => $jobListing['employmentEquity']->getName(),
                    ),
                    array(
                        'term' => $jobListing['industry']->getName(),
                    ),
                    array(
                        'term' => $jobListing['category']->getName(),
                    ),
                ));
                $feed->addEntry($entry);
            }
        }
        echo $feed->export('rss');
    }

}

