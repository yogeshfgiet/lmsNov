
        
 

<fieldset>
            
                 {!! Form::hidden(
                            'showing_id',
                            '',
                            array('id'=>'showing_id','class' => 'form-control', 'rows' => '4' )
                        ) !!}   
             
         
                 <div class="form-group">
                        <label class="col-md-5 control-label" for="Client show up">First name</label>

                       
                     
                            
                             <label class="col-md-4 control-label" for="post_date"><?php print_r($showingUsers->first_name);?></label>
                      
                   

                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="Client show up">Last name</label>

                       
                     
                            
                             <label class="col-md-4 control-label" for="post_date"><?php print_r($showingUsers->last_name);?></label>
                      
                   

                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="Client show up"> Contact number</label>

                       
                     
                            
                             <label class="col-md-4 control-label" for="post_date"><?php print_r($showingUsers->phone_number);?></label>

                    </div>
                     <div class="form-group">
                        <label class="col-md-5 control-label" for="Client show up">Email</label>

                       
                     
                            
                             <label class="col-md-4 control-label" for="post_date"><?php print_r($showingUsers->email);?></label>

                    </div>
                     <div class="form-group">
                        <label class="col-md-5 control-label" for="Client show up">City</label>

                       
                     
                            
                             <label class="col-md-4 control-label" for="post_date"><?php print_r($states[$showingUsers->state_id]);?></label>

                    </div>
                      <div class="form-group">
                        <label class="col-md-5 control-label" for="Client show up">Country</label>

                       
                     
                            
                             <label class="col-md-4 control-label" for="post_date"><?php print_r("USA");?></label>

                    </div>
                     <div class="form-group">
              
                    </div>



            </fieldset>
