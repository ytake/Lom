<?php
declare(strict_types=1);

/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 *
 * Copyright (c) 2018 Yuuki Takezawa
 */

namespace Ytake\Lom\Exception;

use Ytake\Lom\Meta\AllArgsConstructor;
use Ytake\Lom\Meta\Data;
use Ytake\Lom\Meta\NoArgsConstructor;
use Ytake\Lom\Meta\Value;

/**
 * Class ThrowInconsistency.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ThrowInconsistency implements Throwable
{
    /**
     * @param array $annotations
     *
     * @throw InconsistencyException
     */
    public function detectAnnotationErrorThrow(array $annotations): void
    {
        if (array_key_exists(NoArgsConstructor::class, $annotations)
            && array_key_exists(AllArgsConstructor::class, $annotations)
        ) {
            throw new InconsistencyException();
        }
        if (array_key_exists(Data::class, $annotations)
            && array_key_exists(Value::class, $annotations)
        ) {
            throw new InconsistencyException();
        }
    }
}
