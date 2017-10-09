<?php

class TemplateManager
{
    /**
     * @param Template $tpl
     * @param array $data
     *
     * @return Template
     */
    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone $tpl;
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    /**
     * @param string $text
     * @param array $data
     *
     * @return string
     */
    private function computeText($text, array $data)
    {
        $applicationContext = ApplicationContext::getInstance();

        $quote = (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;

        if ($quote)
        {
            $site = SiteRepository::getInstance()->getById($quote->siteId);
            $destination = DestinationRepository::getInstance()->getById($quote->destinationId);

            if ($this->hasText($text, '[quote:summary_html]')) {
                $text = $this->replaceText(
                    '[quote:summary_html]',
                    $quote->renderHtml($quote),
                    $text
                );
            }
            if ($this->hasText($text, '[quote:summary]')) {
                $text = $this->replaceText(
                    '[quote:summary]',
                    $quote->renderText($quote),
                    $text
                );
            }

            if ($this->hasText($text, '[quote:destination_name]') && $destination instanceof Destination) {
                $text = $this->replaceText('[quote:destination_name]',$destination->getCountryName(),$text);
            }
        }

        if ($quote instanceof Quote && $site instanceof Site && $destination instanceof Destination)
            $text = $this->replaceText('[quote:destination_link]', $site->getUrl() . '/' . $destination->getCountryName() . '/quote/' . $quote->getId(), $text);
        else
            $text = $this->replaceText('[quote:destination_link]', '', $text);

        /*
         * USER
         * [user:*]
         */
        $user  = (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $applicationContext->getCurrentUser();
        if($user instanceof User && $this->hasText($text, '[user:first_name]')) {
            $text = $this->replaceText('[user:first_name]', $user->getFirstname(), $text);
        }

        return $text;
    }

    /**
     * @param string $content
     * @param string $search
     *
     * @return bool
     */
    private function hasText($content, $search)
    {
        return strpos($content, $search) !== false;
    }

    /**
     * @param string $search
     * @param string $replace
     * @param string $content
     *
     * @return string
     */
    private function replaceText($search, $replace, $content)
    {
        return str_replace($search, $replace, $content);
    }
}
