<?php include_once "_header.php" ?>
<div>
    <h1 class="font-semibold sm:text-xl md:text-2xl mb-1 leading-tight">
        Exploring the good things of Laravel through my journey with web frameworks! This will be interesting.
    </h1>
    <div class="text-gray-600 text-xs md:text-sm mb-3">
        Published 1 year ago on
        <a href="#" class="text-blue-400 hover:text-blue-700 focus:outline-none focus:text-blue-700">PHP</a>
        <span class="whitespace-no-wrap">by <span class="text-gray-800">Al Imran Ahmed</span></span>
    </div>
    <div class="text-sm md:text-lg leading-relaxed">
        The Winter season had just ended. It was the very beginning of Spring though there were still the feel of Winter
        outside Dhaka. I was planning to visit Mymensingh for a long time but unfortunately, it was just in the plan.
        Finally, I took the action to visit. Luckily, I have a brother who has just finished his Masters in Bangladesh
        Agricultural University(BAU), Mymensingh.

        Although Mymensingh is the capital of the Mymensingh Division of Bangladesh, it is not a much-visited city as far
        as I know. So, I visited the city without any expectation as It was just a plan to visit all the remarkable cities
        of my own country, not to see any particular thing. I visited there just see the city, the livelihood of people
        and some unknown but remarkable places. The city is located on the Brahmaputra River, not very far from Dhaka, the
        capital of Bangladesh.

        Train From Dhaka to Mymensingh
        I bought a ticket for train Tista that left the Airport Railway station at 8:00 AM. It was quite an early morning
        for me as I am not an early bird. To my surprise, when I got out of the home to reach the station I found Dhaka
        already well awaken. Dhaka is another city that doesn't sleep. The train was on time, it was leaving Dhaka behind
        and instead of using any smart device I kept my eye opened looking outside through the window beside me. As soon
        as the train passes the busy atmosphere of Dhaka, the weather got changed! Seems like outside of Dhaka was still
        sleeping, there was still fogs out there to cover the asleep trees and grass from our sight. I was having a
        feeling of going near nature to breathe natural air...

        Fog from train
        The train reached Mymensingh station at around 11:00 AM being almost 40 minutes late. I think this delay was due
        to fogs on the road. By the way, my brother was standing in the station to receive me. This was the starting of
        mission Mymensingh!

        <pre>
      <code class="language-php line-numbers">
        class Math
        {
           protected $number1;

           protected $number2;

           public function add()
           {
               return $this->number1 + $this->number1;
           }

           public function subtract()
           {
               return $this->number1 - $this->number2;
           }
        }
      </code>
    </pre>

        Bangladesh Agricultural University(BAU)
        From the station, we went straight to BAU, one of the biggest agricultural universities in Asia. The university is
        so big that I don't have enough time to visit even just interesting things about the university on foot.
        Therefore, we took the traditional vehicle of Bangladesh, rickshaw. We visited places like Fish Museum
        Biodiversity Center(FMBC), the road that contains lines of mango trees in two sides then blackberry trees then
        litchi trees!
    </div>
    <div class="mb-3">
        <?php include '_tags.php' ?>
    </div>
</div>

<!--<div class="mb-3">-->
<!--  <h2 class="border-b border-blue-300 text-xl md:text-2xl font-bold">-->
<!--    More articles on <a href="#" class="text-blue-400 hover:text-blue-700 focus:outline-none-->
<!--    focus:text-blue-700">PHP</a>-->
<!--  </h2>-->
<!--    --><?php //foreach (range(1, 3) as $i): ?>
<!--        --><?php //include '_list_card.php' ?>
<!--    --><?php //endforeach; ?>
<!--</div>-->

<div>
    <?php include '_comment_form.php' ?>
</div>

<div class="my-3">
    <h2 class="border-b border-blue-300 text-xl md:text-2xl font-bold">
        Comments
    </h2>
    <?php foreach (range(1, 3) as $i): ?>
        <?php include '_comment.php' ?>
    <?php endforeach; ?>
</div>

<?php include_once "_footer.php" ?>
