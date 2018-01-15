<?php

namespace TomLingham\Searchy\SearchDrivers;

class FuzzySearchUnicodeDriver extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \TomLingham\Searchy\Matchers\ExactMatcher::class                        => 100,
        \TomLingham\Searchy\Matchers\StartOfStringMatcher::class                => 50,
        \TomLingham\Searchy\Matchers\AcronymUnicodeMatcher::class               => 42,
        \TomLingham\Searchy\Matchers\ConsecutiveCharactersUnicodeMatcher::class => 40,
        \TomLingham\Searchy\Matchers\StartOfWordsMatcher::class                 => 35,
        \TomLingham\Searchy\Matchers\StudlyCaseUnicodeMatcher::class            => 32,
        \TomLingham\Searchy\Matchers\InStringMatcher::class                     => 30,
//        \TomLingham\Searchy\Matchers\TimesInStringMatcher::class                => 8,

  ];
}
/***
 * ExactMatcher

    完全匹配

    StartOfStringMatcher

    匹配字符串开头是否一致，比如“hel”和“Hello World”

    AcronymMatcher

    匹配字符串缩写，例如“fb”和“foo bar”或“Fred Brown”

    ConsecutiveCharactersMatcher

    匹配字符串是否包含一致的连续字符，此外还会计算匹配字符所占百分比并应用相应的乘法因子，例如搜索“fba”会匹配“foo bar”或者“Afraid of bats”，而不会匹配“fabulous”

    StartOfWordsMatcher

    匹配字符串开头的单词是否一致，例如，“jo ta”与“John Taylor”或者“Joshua B. Takeshi”

    StudlyCaseMatcher

    驼峰式匹配，例如“hp”和“HtmlServiceProvider”或者“HashParser”，但不会匹配“hasProvider”

    InStringMatcher

    字符串包含匹配，例如“smi”和“John Smith”或者“Smiley Face”

    TimesInStringMatcher

    字符串包含次数匹配，例如搜索“tha”会匹配“I hope that that cat has caught that mouse”（3×）或者“Thanks, it was great!”（1×）
 *
 * */