
<div class='user index'>
    <div>
         <?php echo '<font color="red">'.$this->Session->flash().'</font>'; ?>	
    </div>
    <h3>テストのタイトル：<?php echo $test['title'];?></h3>
    <?php if(isset($result)) { ?>
    <p>Bạn đã hoàn thành bài test.Tổng điểm đạt được là : <?php echo $result.'/'.$score ?> </p>
    <?php } ?>
    --------------------------------------------------------------------------------------------------
    <?php
        echo $this->Form->create('User', array('type'=> 'post'));
    ?>
    <table>
            <tr>
                    <td><?php
                    foreach ($test['questions'] as $key => $question) {
                            $attr = array('seperator' => '<br/>');
                            //echo "<h4>".$question['question']."</h4>";
                            echo $this->Form->radio($question['question'], $question['answers'], $attr);
                            if(isset($result)) {
                                if(!in_array($key+1, $true_ques)) {
                                    echo '<font color="red">Trả lời sai</font>'.'<br>';
                                    echo '<font color="red">Đáp án đúng là:'.$question['correct'].'-'.$question['answers'][$question['correct']-1].'</font><br>';
                                } else {
                                    echo '<font color="blue">Trả lời đúng</font>'.'<br>';
                                }                                   
                            }
                            echo "--------------------------------------------------------------------------------------------------";
                    }
                    ?></td>
            </tr>
    </table>
    <?php if(isset($result)) { ?>
        <input type="hidden" name="result" value="<?php echo $result ?>">
        <input type="submit" name="confirm" value="Confirm">
    <?php } else { ?>
        <input type="submit" name="submit" value="Submit">
    <?php } ?>
                    <?php
                    echo $this->Form->end();
                    ?>
</div>
