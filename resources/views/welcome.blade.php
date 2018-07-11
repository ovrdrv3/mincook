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
                <div class="form-row" v-for="ingredient in recipe.ingredients" :key="ingredient.sort">
                  <div class="col-md-2 mb-3">
                    <label for="amount" v-show="ingredient.sort == 1">Amount</label>
                    <input type="text" class="form-control" v-model="ingredient.amount" placeholder="" value="ingredient.amount">
                  </div>
                  <div class="col-md-10 mb-3">
                    <label for="do" v-show="ingredient.sort == 1">Food</label>
                    <div class="input-group">
                      <input type="text" class="form-control" v-model="ingredient.do" placeholder="" value="ingredient.amount" required>
                    </div>
                  </div>
                </div>
                <hr>
                <h2>Instructions</h2>
                <div class="form-row" v-for="instruction in recipe.instructions" :key="instruction.sort">
                         <div class="col-md-1 mb-3">
                            <label for="sort" v-show="instruction.sort == 1">Order</label>
                            <input type="text" class="form-control" v-model="instruction.sort" placeholder="" tabindex="-1" value="instruction.sort" readonly style="background-color:transparent; border: 0; font-size: 1em;">
                          </div>
                          <div class="col-md-10 mb-3">
                            <label for="do" v-show="instruction.sort == 1">Step</label>
                            <div class="input-group">
                              <textarea class="form-control" v-model="instruction.do" id="do" rows="1" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-1 mb-3 center-text">
                            <label for="buttons" v-show="instruction.sort == 1">Change</label>
                            <br v-if="instruction.sort == 1">
                            <font-awesome-icon icon="arrow-up" v-if="instruction.sort != 1" @click="shiftStepUp(instruction.sort)" size="lg" ></font-awesome-icon>
                            <font-awesome-icon icon="arrow-down" v-if="instruction.sort != recipe.instructions.length" @click="shiftStepDown(instruction.sort)" size="lg" ></font-awesome-icon>
                            <font-awesome-icon icon="trash" @click="removeStep(instruction.sort)" size="lg" ></font-awesome-icon>
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
