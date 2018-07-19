<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- CSS and Fonts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                /*font-size: 2em; */
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div id="app" class="container my-5">
          <H1>Add a new recipe</H1>
                <div class="form-group">
                    <input class="form-control" placeholder="Name" v-model="recipe.name">
                </div>
                <div class="form-group">
                    <textarea class="form-control" placeholder="Description" v-model="recipe.description"></textarea>
                </div>

                <h2>Ingredients</h2>

                <div class="form-row"
                v-for="(ingredient, index) in recipe.ingredients"
                :key="ingredient.sort">
                  <div class="col-md-2 mb-3">
                    <label for="amount" v-show="index == 0">Amount</label>
                    <input type="text" class="form-control" v-model="ingredient.amount" placeholder="">
                  </div>
                  <div class="col-md-10 mb-3">
                    <label for="do" v-show="index == 0">Food</label>
                    <div class="input-group">
                      <input type="text" class="form-control" v-model="ingredient.do" placeholder="" required>
                    </div>
                  </div>
                </div>
                <hr>

                <h2>Instructions</h2>

                <div class="form-row"
                v-for="(instruction, index) in recipe.instructions"
                :key="instruction.sort">
                  <div class="col-md-1 mb-3">
                    <label for="sort" v-show="index == 0">Order</label>

                    <input
                    v-model="instruction.sort"
                    value="instruction.sort"
                    type="text" class="form-control" placeholder="" tabindex="-1" style="background-color:transparent; border: 0; font-size: 1em;" readonly>

                  </div>
                  <div class="col-md-10 mb-3">
                    <label for="do" v-show="index == 0">Step</label>
                    <div class="input-group">
                      <textarea
                      :ref="'step'"
                      @keydown.enter.prevent="addInstruction"
                      @keyup.delete="removeStepWithBackspace('instructions', index)"
                      v-model="instruction.do" class="form-control"
                      rows="3" required></textarea>
                    </div>
                  </div>
                  <div class="col-md-1 mb-3 center-text">
                    <label for="buttons" v-show="index == 0">Change</label>
                    <br v-if="index == 0">

                    <font-awesome-icon icon="arrow-up" size="lg"
                    v-if="index != 0"
                    @click="shiftStepUp('instructions', index)"></font-awesome-icon>

                    <font-awesome-icon icon="arrow-down" size="lg"
                    v-if="index != recipe.instructions.length - 1"
                    @click="shiftStepDown('instructions', index)"></font-awesome-icon>

                    <font-awesome-icon icon="trash" size="lg"
                    @click="removeStep('instructions', index)"></font-awesome-icon>

                  </div>
                </div>

                <div class="form-group">
                    <button class="form-control" @click="addInstruction">Add new step</button>
                </div>
                <div class="form-group">
                    <button class="form-control" @click.prevent="addRecipe">Submit</button>
                </div>
        </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    </body>

</html>
