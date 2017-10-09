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
            $quoteFromRepository = QuoteRepository::getInstance()->getById($quote->id);
            $usefulObject = SiteRepository::getInstance()->getById($quote->siteId);
            $destinationOfQuote = DestinationRepository::getInstance()->getById($quote->destinationId);

            if ($this->hasText($text, '[quote:destination_link]')) {
                $destination = DestinationRepository::getInstance()->getById($quote->destinationId);
            }

            if ($this->hasText($text, '[quote:summary_html]')) {
                $text = $this->replaceText(
                    '[quote:summary_html]',
                    Quote::renderHtml($quoteFromRepository),
                    $text
                );
            }
            if ($this->hasText($text, '[quote:summary]')) {
                $text = $this->replaceText(
                    '[quote:summary]',
                    Quote::renderText($quoteFromRepository),
                    $text
                );
            }

            if ($this->hasText($text, '[quote:destination_name]')) {
                $text = $this->replaceText('[quote:destination_name]',$destinationOfQuote->countryName,$text);
            }
        }

        if (isset($destination))
            $text = $this->replaceText('[quote:destination_link]', $usefulObject->url . '/' . $destination->countryName . '/quote/' . $quoteFromRepository->id, $text);
        else
            $text = $this->replaceText('[quote:destination_link]', '', $text);

        /*
         * USER
         * [user:*]
         */
        $user  = (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $applicationContext->getCurrentUser();
        if($user && $this->hasText($text, '[user:first_name]')) {
            $text = $this->replaceText('[user:first_name]'       , ucfirst(mb_strtolower($user->firstname)), $text);
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
